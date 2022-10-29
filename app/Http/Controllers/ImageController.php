<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    public function imageStore(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:500',
        ]);

        $image_path = $request->file('image')->store('images', 'public');
        $oname = $request->file('image')->getClientOriginalName();
        $data = Image::create([
            'name' => $oname,
            'path' => $image_path,
        ]);

        return response($data, Response::HTTP_CREATED);
    }
}
