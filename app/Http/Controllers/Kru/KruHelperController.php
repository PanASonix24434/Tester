<?php

namespace App\Http\Controllers\Kru;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Kru\KruApplicationDocument;
use App\Models\Kru\KruDocument;
use App\Models\Kru\KruForeignDocument;
use App\Models\Payment\Receipt;
use App\Models\Systems\AuditLog;
use App\Models\Vessel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KruHelperController extends Controller
{
    // //Download Receipt
    // public function downloadReceipt($id)
    // {
    //     $doc = Receipt::find($id);

    //     if (Storage::exists($doc->file_path)) {

    //         //Format - PDF
    //         if (Str::contains($doc->file_path, '.pdf'))
    //         {
    //             $headers = [
    //                 'Content-Type' => 'application/pdf',
    //             ];
    //         }
    //         //Format - JPG
    //         elseif(Str::contains($doc->file_path, '.jpg'))
    //         {
    //             $headers = [
    //                 'Content-Type' => 'application/jpg',
    //             ];
    //         }
    //         //Format - PNG
    //         elseif(Str::contains($doc->file_path, '.PNG'))
    //         {
    //             $headers = [
    //                 'Content-Type' => 'application/PNG',
    //             ];
    //         }
    //         else
    //         {
    //             $headers = [
    //                 'Content-Type' => 'application/pdf',
    //             ];
    //         }

    //         return Storage::download($doc->file_path, $doc->file_name, $headers);
    //     }
    //     return redirect('/404');
    // }

    public function previewReceipt($id) {
        $doc = Receipt::findOrFail($id); // Assuming you have a Document model
    
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

	//Delete Receipt
    public function deleteReceipt($id)
    {
        DB::beginTransaction();

        try 
        {
            $rec = Receipt::find($id);
			$rec->delete();
            
            $audit_details = json_encode([
                'receipt_id' => $id,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru01TerimaanBayaran', 'deleteReceipt', $audit_details);

            DB::commit();

            return redirect()->back()->with('alert', 'Maklumat Bayaran berjaya dihapus !!');
        }
        catch (Exception $e) {

            DB::rollback();
            $audit_details = json_encode([
                'receipt_id' => $id,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru01TerimaanBayaran', 'deleteReceipt', $audit_details, $e->getMessage());
            return redirect()->back()->with('alert', 'Maklumat Bayaran gagal dihapus !!');
        }
    }
    
	//Delete Receipt
    public static function generatePinNumber()
    {
        // Available alpha caracters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate a pin based on 4 digits + 4 random character
        $pin = mt_rand(1000, 9999)
        . $characters[rand(0, strlen($characters) - 1)]
            . $characters[rand(0, strlen($characters) - 1)]
            . $characters[rand(0, strlen($characters) - 1)]
            . $characters[rand(0, strlen($characters) - 1)];

        // shuffle the result
        $pinNumber = str_shuffle($pin);

        return $pinNumber;
    }

    public static function mykadbirthplacecode()
    {
        $birthplacecode = [
            '01', '21', '22', '23', '24',   //johor
            '02', '25', '26', '27',         //kedah
            '03', '28', '29',               //kelantan
            '04', '30',                     //melaka
            '05', '31', '59',               //negeri sembilan
            '06', '32', '33',               //pahang
            '07', '34', '35',               //pulau pinang
            '08', '36', '37', '38', '39',   //perak
            '09', '40',                     //perlis
            '10', '41', '42', '43', '44',   //selangor
            '11', '45', '46',               //terengganu
            '12', '47', '48', '49',         //sabah
            '13', '50', '51', '52', '53',   //sarawak
            '14', '54', '55', '56', '57',   //wp kl
            '15', '58',                     //wp labuan
            '16',                           //wp putrajaya
            '88',                           //polis
            '99',                           //tentera
        ];

        return $birthplacecode;
    }

    // public static function checkMYKADorMYPRfromIC(string $icNumber)
    // {
        
    //     $ic_7_8_digit = substr($icNumber, 6, 8);
    //     $birthplacecode = array(
    //         '01', '21', '22', '23', '24',   //johor
    //         '02', '25', '26', '27',         //kedah
    //         '03', '28', '29',               //kelantan
    //         '04', '30',                     //melaka
    //         '05', '31', '59',               //negeri sembilan
    //         '06', '32', '33',               //pahang
    //         '07', '34', '35',               //pulau pinang
    //         '08', '36', '37', '38', '39',   //perak
    //         '09', '40',                     //perlis
    //         '10', '41', '42', '43', '44',   //selangor
    //         '11', '45', '46',               //terengganu
    //         '12', '47', '48', '49',         //sabah
    //         '13', '50', '51', '52', '53',   //sarawak
    //         '14', '54', '55', '56', '57',   //wp kl
    //         '15', '58',                     //wp labuan
    //         '16',                           //wp putrajaya
    //         '88',                           //polis
    //         '99',                           //tentera
    //     );

    //     return in_array($ic_7_8_digit, $birthplacecode)?'MYKAD':'MYPR';
    // }

    //Download Document
    // public function downloadDoc($id)
    // {
    //     $doc = KruApplicationDocument::find($id);

    //     if (Storage::exists($doc->file_path)) {

    //         //Format - PDF
    //         if (Str::contains($doc->file_path, '.pdf'))
    //         {
    //             $headers = [
    //                 'Content-Type' => 'application/pdf',
    //             ];
    //         }
    //         //Format - JPG
    //         elseif(Str::contains($doc->file_path, '.jpg'))
    //         {
    //             $headers = [
    //                 'Content-Type' => 'application/jpg',
    //             ];
    //         }
    //         //Format - PNG
    //         elseif(Str::contains($doc->file_path, '.PNG'))
    //         {
    //             $headers = [
    //                 'Content-Type' => 'application/PNG',
    //             ];
    //         }
    //         else
    //         {
    //             $headers = [
    //                 'Content-Type' => 'application/pdf',
    //             ];
    //         }

    //         return Storage::download($doc->file_path, $doc->file_name, $headers);
    //     }
    //     return redirect('/404');
    // }

    public function previewDoc($id) {
        $doc = KruApplicationDocument::findOrFail($id); // Assuming you have a Document model
    
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

    public function previewKruDoc($id) {
        $doc = KruDocument::findOrFail($id); // Assuming you have a Document model
    
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

    public function previewKruForeignDoc($id) {
        $doc = KruForeignDocument::findOrFail($id); // Assuming you have a Document model
    
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
    
    //Download Kru Document
    public function downloadKruForeignDoc($id)
    {
        $doc = KruForeignDocument::find($id);

        if (Storage::exists($doc->file_path)) {

            //Format - PDF
            if (Str::contains($doc->file_path, '.pdf'))
            {
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
            }
            //Format - JPG
            elseif(Str::contains($doc->file_path, '.jpg'))
            {
                $headers = [
                    'Content-Type' => 'application/jpg',
                ];
            }
            //Format - PNG
            elseif(Str::contains($doc->file_path, '.PNG'))
            {
                $headers = [
                    'Content-Type' => 'application/PNG',
                ];
            }
            else
            {
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
            }

            return Storage::download($doc->file_path, $doc->file_name, $headers);
        }
        return redirect('/404');
    }

    public function deleteDoc(Request $request, string $id)
    {
        DB::beginTransaction();

        try 
        {
            //Update status in table applications
            $appDoc = KruApplicationDocument::find($id);
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

    public function deleteKruDoc(Request $request, string $id)
    {
        DB::beginTransaction();

        try 
        {
            //Update status in table applications
            $appDoc = KruDocument::find($id);
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

    public function deleteKruForeignDoc(Request $request, string $id)
    {
        DB::beginTransaction();

        try 
        {
            //Update status in table applications
            $appDoc = KruForeignDocument::find($id);
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

    public function downloadPKN(){

        $file = public_path()."/documents/PKN.pdf";
        $headers = array('Content-Type: application/pdf',);
        return Response::download($file, 'PKN.pdf',$headers);
    }

    // //calculation based on buku dasar page 180
    // public static function maximumKruInVessel($vessel_id)
    // {
    //     //check vessel exist
    //     $vessel = Vessel::withTrashed()->find($vessel_id);
    //     if ($vessel == null) return null;

    //     //check equipment and grt exist
    //     $peralatan_utama = CodeMaster::withTrashed()->find($vessel->peralatan_utama);
    //     $grt = $vessel->grt;
    //     if ($peralatan_utama == null || $grt == null) return null;

    //     $maximumKru = 0;
    //     if($peralatan_utama->name_ms=='PUKAT TUNDA'){
    //         if ($grt < 40)      $maximumKru = 4;
    //         elseif ($grt < 70)  $maximumKru = 7;
    //         elseif ($grt < 100) $maximumKru = 10;
    //         elseif ($grt < 150) $maximumKru = 12;
    //         else                $maximumKru = 14;
    //     }
    //     else if($peralatan_utama->name_ms=='PUKAT JERUT') {
    //         if ($grt < 40)      $maximumKru = 15;
    //         elseif ($grt < 70)  $maximumKru = 30;
    //         elseif ($grt < 100) $maximumKru = 35;
    //         elseif ($grt < 150) $maximumKru = 40;
    //         else                $maximumKru = 45;
    //     }
    //     else{
    //         if ($grt < 40)      $maximumKru = 3;
    //         elseif ($grt < 70)  $maximumKru = 10;
    //         elseif ($grt < 100) $maximumKru = 15;
    //         elseif ($grt < 150) $maximumKru = 20;
    //         else                $maximumKru = 25;
    //     }
    //     return $maximumKru;
    // }
}
