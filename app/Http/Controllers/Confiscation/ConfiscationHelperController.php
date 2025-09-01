<?php

namespace App\Http\Controllers\Confiscation;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\ConfiscationDoc;
use Illuminate\Support\Facades\Storage;

class ConfiscationHelperController extends Controller
{

    public function downloadDoc($id)
    {
        // $doc = MortgageDocuments::find($id);

        $doc = ConfiscationDoc::find($id);

        if (Storage::exists($doc->file_path)) {

            //Format - PDF
            if (Str::contains($doc->file_path, '.pdf')) {
                $headers = [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline',                 ];
            }
            // Format for JPG
            elseif (Str::contains($doc->file_path, '.jpg')) {
                $headers = [
                    'Content-Type' => 'image/jpeg',
                    'Content-Disposition' => 'inline',
                ];
            }
            // Format for PNG
            elseif (Str::contains($doc->file_path, '.png')) {
                $headers = [
                    'Content-Type' => 'image/png',
                    'Content-Disposition' => 'inline',
                ];
            } else {
                // Fallback format
                $headers = [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline',
                ];
            }

            // Display the file in the browser
            return response()->file(storage_path('app/' . $doc->file_path), $headers);
        }

        return redirect('/404');
    }
}
