<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Services\Patient\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
         return response()->json($this->imageService->getAll());
    }

    public function store(Request $request)
    {
       $data= $request->validate([
            'file_path' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $image = $this->imageService->store($data);


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

        $image = $this->imageService->update($image, $data);

        return response()->json([
            'message' => 'تم تعديل بيانات الصورة',
            'data' => $image
        ]);
    }

    public function destroy(Image $image)
    {
        $this->imageService->delete($image);

        return response()->json([
            'message' => 'تم حذف الصورة'
        ]);
    }
}
