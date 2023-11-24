<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Gallery; // Use the correct model
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    // public function store(Request $request)
    // {
    //     // Validate the request.
    //     $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     // Get the image file.
    //     $image = $request->file('image');

    //     // Generate a unique filename for the image.
    //     $filename = time() . '.' . $image->getClientOriginalExtension();

    //     // Save the image file to the server.
    //     $image->storeAs('public/images', $filename);

    //     $imageModel = new Gallery(); 
    //     $imageModel->name = $filename; 
    //     $imageModel->path = 'public/images/' . $filename;
    //     $imageModel->save();

    //     // Return a success response.
    //     return response()->json([
    //         'message' => 'Image uploaded successfully!',
            
    //     ]);
    // }
    public function saveDoc(Request $request)
    {
        $user = Auth::user();
        $file = $request->image;
        $ext = $file->getClientOriginalExtension();
        
        $filename = md5(explode('.', $file->getClientOriginalName())[0]).'.'.$ext;
        Storage::disk('public')->put('/images/'.$filename, File::get($file));

        $imageModel = new Gallery(); 
        $imageModel->filename = $filename; 
        $imageModel->user_id = $user->id;
        $imageModel->save();

    }

}
