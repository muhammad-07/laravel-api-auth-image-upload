<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\returnSelf;

class ImageController extends Controller
{
    public function imageStore(Request $request)
    {
        // $this->validate($request, [
        //     'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:500',
        // ]);

        $validator = Validator::make($request->all(),['image' => 'required:image|mimes:png,jpg,jpeg,gif,svg|max:500']);
        if($validator->fails())
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors(),
                ]
            );

        $image_path = $request->file('image')->store('images', 'public');
        $oname = $request->file('image')->getClientOriginalName();
        $data = Image::create([
            'name' => $oname,
            'path' => $image_path,
        ]);

        return response($data, Response::HTTP_CREATED);
    }
}
