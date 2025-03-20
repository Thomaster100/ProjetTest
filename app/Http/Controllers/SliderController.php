<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SliderImage;

class SliderController extends Controller {

    public function index()
    {
        $images = SliderImage::all(); // Récupère toutes les images stockées
        return view('slider.index', compact('images'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);

        $path = $request->file('image')->store('slider', 'public');

        $image = SliderImage::create(['path' => $path]);

        return response()->json([
            'success' => true,
            'image' => $image
        ]);
    }

    public function delete($id)
    {
        $image = SliderImage::findOrFail($id);
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return response()->json(['success' => true]);
    }
}
