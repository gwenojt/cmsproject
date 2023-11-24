<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class ImageController extends Controller
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

    //     // Create a new Image model in the database.
    //     $imageModel = new Image();
    //     $imageModel->name = $filename;
    //     $imageModel->path = 'public/images/' . $filename;
    //     $imageModel->category = $request->get('category');
    //     $imageModel->status = $request->get('status');
    //     $imageModel->save();

    //     // Return a success response.
    //     return response()->json([
    //         'message' => 'Image uploaded successfully!',
    //     ]);
    // }

    public function tableImages(){
        $show = Images::all();
        return $show;


    }

    public function saveImages(Request $request)
    {
        $user = Auth::user();
        $images = $request->file('images');
    
        foreach ($images as $image) {
            $ext = $image->getClientOriginalExtension();
            $filename = md5(explode('.', $image->getClientOriginalName())[0]) . '.' . $ext;
    
            $path = $image->store('images', 'public');
    
            $imageModel = new Image();
            $imageModel->name = $image->getClientOriginalName();
            $imageModel->path = $path;
            $imageModel->user_id = $user->id;
            $imageModel->category = $request->category;
            $imageModel->status = $request->status;
            $imageModel->save();
        }
    
        return redirect()->back();
    }
    

    
}
