<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attachment = Attachment::find($id);

        try {
            if (Storage::disk('public')->exists((!empty($attachment->path) ? $attachment->path.'/' : '').$attachment->filename)) {
                Storage::disk('public')->delete((!empty($attachment->path) ? $attachment->path.'/' : '').$attachment->filename);
            }
            $attachment->delete();
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
