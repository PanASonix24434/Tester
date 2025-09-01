<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\StatusStock;
use App\Models\FishType;
use App\Models\FMAComposition;
use App\Models\LicensingQuota;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class StockDocumentProcessorController extends Controller
{
    /**
     * Process uploaded stock management documents
     */
    public function processDocument(Request $request)
    {
        try {
            $request->validate([
                'document' => 'required|file|mimes:pdf,xlsx,xls,csv|max:10240',
                'document_type' => 'required|in:fma_composition,licensing_quota',
                'year' => 'required|integer|min:2020|max:2030'
            ]);

            $file = $request->file('document');
            $documentType = $request->document_type;
            $year = $request->year;

            Log::info("Processing document: {$file->getClientOriginalName()}, Type: {$documentType}, Year: {$year}");

            // Store the uploaded file
            $filePath = $file->storeAs('stock_documents', time() . '_' . $file->getClientOriginalName(), 'public');

            // Process based on document type
            $result = null;
            switch ($documentType) {
                case 'fma_composition':
                    $result = $this->processFMAComposition($filePath, $year);
                    break;
                case 'licensing_quota':
                    $result = $this->processLicensingQuota($filePath, $year);
                    break;
            }

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Dokumen berjaya diproses dan data telah dikemaskini',
                    'data' => $result,
                    'file_path' => $filePath
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses dokumen'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error processing stock document: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ralat memproses dokumen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process FMA Composition document
     */
    private function processFMAComposition($filePath, $year)
    {
        try {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $data = [];

            if (in_array($extension, ['xlsx', 'xls'])) {
                $data = $this->readExcelFile($filePath);
            } elseif ($extension === 'csv') {
                $data = $this->readCSVFile($filePath);
            }

            // Process FMA composition data
            $processedData = $this->extractFMACompositionData($data);
            
            // Update or create FMA records in database
            $this->updateFMACompositionDatabase($processedData, $year);

            return [
                'type' => 'fma_composition',
                'records_processed' => count($processedData),
                'year' => $year
            ];

        } catch (\Exception $e) {
            Log::error('Error processing FMA composition: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Process Licensing Quota document
     */
    private function processLicensingQuota($filePath, $year)
    {
        try {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $data = [];

            if (in_array($extension, ['xlsx', 'xls'])) {
                $data = $this->readExcelFile($filePath);
            } elseif ($extension === 'csv') {
                $data = $this->readCSVFile($filePath);
            }

            // Process licensing quota data
            $processedData = $this->extractLicensingQuotaData($data);
            
            // Update or create quota records in database
            $this->updateLicensingQuotaDatabase($processedData, $year);

            return [
                'type' => 'licensing_quota',
                'records_processed' => count($processedData),
                'year' => $year
            ];

        } catch (\Exception $e) {
            Log::error('Error processing licensing quota: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Read Excel file and return data
     */
    private function readExcelFile($filePath)
    {
        $fullPath = Storage::disk('public')->path($filePath);
        $spreadsheet = IOFactory::load($fullPath);
        $worksheet = $spreadsheet->getActiveSheet();
        
        $data = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }
            if (!empty(array_filter($rowData))) {
                $data[] = $rowData;
            }
        }
        
        return $data;
    }

    /**
     * Read CSV file and return data
     */
    private function readCSVFile($filePath)
    {
        $fullPath = Storage::disk('public')->path($filePath);
        $data = [];
        
        if (($handle = fopen($fullPath, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (!empty(array_filter($row))) {
                    $data[] = $row;
                }
            }
            fclose($handle);
        }
        
        return $data;
    }

    /**
     * Extract FMA Composition data from processed data
     */
    private function extractFMACompositionData($data)
    {
        $fmaData = [];
        
        foreach ($data as $row) {
            if (count($row) >= 3 && is_numeric($row[0])) {
                $fmaData[] = [
                    'fma_number' => (int)$row[0],
                    'states' => trim($row[1]),
                    'chairman' => trim($row[2])
                ];
            }
        }
        
        return $fmaData;
    }

    /**
     * Extract Licensing Quota data from processed data
     */
    private function extractLicensingQuotaData($data)
    {
        $quotaData = [];
        
        foreach ($data as $rowIndex => $row) {
            if ($rowIndex === 0) continue; // Skip header row
            
            if (count($row) >= 8) {
                $category = trim($row[0]);
                $quotas = [];
                
                for ($i = 1; $i <= 7; $i++) {
                    $quotas["fma_" . str_pad($i, 2, '0', STR_PAD_LEFT)] = !empty($row[$i]) ? $row[$i] : null;
                }
                
                $quotaData[] = [
                    'category' => $category,
                    'quotas' => $quotas
                ];
            }
        }
        
        return $quotaData;
    }

    /**
     * Update FMA Composition database
     */
    private function updateFMACompositionDatabase($fmaData, $year)
    {
        try {
            // Deactivate existing records for this year
            FMAComposition::where('year', $year)->update(['is_active' => false]);
            
            // Create new records
            foreach ($fmaData as $fma) {
                FMAComposition::updateOrCreate(
                    [
                        'fma_number' => $fma['fma_number'],
                        'year' => $year
                    ],
                    [
                        'states' => $fma['states'],
                        'chairman' => $fma['chairman'],
                        'is_active' => true,
                        'created_by' => auth()->id()
                    ]
                );
            }
            
            Log::info("FMA Composition database updated for year {$year}");
            
        } catch (\Exception $e) {
            Log::error("Error updating FMA Composition database: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update Licensing Quota database
     */
    private function updateLicensingQuotaDatabase($quotaData, $year)
    {
        try {
            // Deactivate existing records for this year
            LicensingQuota::where('year', $year)->update(['is_active' => false]);
            
            // Create new records
            foreach ($quotaData as $quota) {
                // Handle sub-categories (e.g., "B Pelagik", "B Demersal")
                $categoryParts = explode(' ', $quota['category'], 2);
                $mainCategory = $categoryParts[0];
                $subCategory = isset($categoryParts[1]) ? $categoryParts[1] : null;
                
                LicensingQuota::updateOrCreate(
                    [
                        'category' => $mainCategory,
                        'sub_category' => $subCategory,
                        'year' => $year
                    ],
                    [
                        'fma_01' => $quota['quotas']['fma_01'],
                        'fma_02' => $quota['quotas']['fma_02'],
                        'fma_03' => $quota['quotas']['fma_03'],
                        'fma_04' => $quota['quotas']['fma_04'],
                        'fma_05' => $quota['quotas']['fma_05'],
                        'fma_06' => $quota['quotas']['fma_06'],
                        'fma_07' => $quota['quotas']['fma_07'],
                        'is_active' => true,
                        'created_by' => auth()->id()
                    ]
                );
            }
            
            Log::info("Licensing Quota database updated for year {$year}");
            
        } catch (\Exception $e) {
            Log::error("Error updating Licensing Quota database: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get processing status
     */
    public function getProcessingStatus()
    {
        return response()->json([
            'status' => 'ready',
            'supported_formats' => ['xlsx', 'xls', 'csv'],
            'document_types' => ['fma_composition', 'licensing_quota']
        ]);
    }
}
