<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportAttachment;
use Illuminate\Support\Facades\Storage;

class ReportAttachmentController extends Controller
{
    public function destroyAttachment($id)
    {
        $attachment = ReportAttachment::findOrFail($id);

        // Optional: delete the file from storage
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        // Soft delete
        $attachment->delete();

        return back()->with('success', 'Attachment deleted successfully.');
    }
}