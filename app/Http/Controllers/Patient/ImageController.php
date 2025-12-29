<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        return response()->json(Image::latest()->get());
    }

    public function store(Request $request)
    {
       $data= $request->validate([
            'file_path' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $image = Image::create($data());

        return response()->json([
            'message' => 'تم رفع الصورة بنجاح',
            'data' => $image
        ]);
    }

    public function show(Image $image)
    {
        return response()->json($image);
    }

    public function update(Request $request, Image $image)
    {
         $data=$request->validate([
            'file_path' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $image->update($data());

        return response()->json([
            'message' => 'تم تعديل بيانات الصورة',
            'data' => $image
        ]);
    }

    public function destroy(Image $image)
    {
        $image->delete();

        return response()->json([
            'message' => 'تم حذف الصورة'
        ]);
    }
}
