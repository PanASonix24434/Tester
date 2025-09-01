<?php

namespace App\Http\Controllers\LandingDeclaration;

use App\Exports\LandingDeclaration\LandingExport;
use App\Http\Controllers\Controller;
use App\Models\LandingDeclaration\LandingDocument;
use App\Models\LandingDeclaration\LandingMonthlyDocument;
use App\Models\Systems\AuditLog;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LandingHelperController extends Controller
{
    public function previewDoc($id) {
        $doc = LandingMonthlyDocument::findOrFail($id); // Assuming you have a Document model
    
        // 1. Check if the file exists
        if (!Storage::exists($doc->file_path)) {
            abort(404, 'File not found.');
        }
    
        // 2. Determine the MIME type (important for browser rendering)
        $mimeType = Storage::mimeType($doc->file_path);
    
        // 3. Create a streamed response (more efficient for large files)
        $response = new StreamedResponse(function () use ($doc) {
            $stream = Storage::readStream($doc->file_path);
            while ($chunk = fread($stream, 1024 * 1024)) { // Read in chunks
                echo $chunk;
                flush(); // Send data immediately
            }
            fclose($stream);
        }, 200, [
            'Content-Type' => $mimeType, // Set the correct MIME type
            'Content-Disposition' => 'inline; filename="' . $doc->file_name . '"', // Crucial for preview
        ]);
    
        return $response;
    }

    public function deleteDoc(Request $request, string $id)
    {
        DB::beginTransaction();

        try 
        {
            //Update status in table applications
            $appDoc = LandingMonthlyDocument::find($id);
            $appDoc->deleted_by=$request->user()->id;
			$appDoc->save();
			$appDoc->delete();

            DB::commit();

            return redirect()->back()->with('alert', 'Dokumen berjaya dihapus !!');
        }
        catch (Exception $e) {

            DB::rollback();
            return redirect()->back()->with('alert', 'Dokumen gagal dihapus !!');
        }
    }
    

    /**
     * Export users to excel.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function exportExcelMonthlyDeclaration(Request $request, $userId, $year, $month ) 
    {
        $user = User::find($userId);
        
        $auditLog = new AuditLog();
        $auditLog->log('LandingHelperController', 'exportExcelMonthlyDeclaration', json_encode(['file_type' => 'Excel']));

        return Excel::download(new LandingExport($userId,$year,$month), 'landingdeclaration_'.$user->username.'_'.$year.'_'.$month.'_'.Carbon::now()->format('YmdHis').'.xlsx');
    }
}
