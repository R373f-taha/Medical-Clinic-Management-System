<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
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

    public function store(StoreImageRequest $request)
    {
        $data = $request->validated();

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

    public function update(UpdateImageRequest $request, Image $image)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

        $image = $this->imageService->update($image, $data);

        return response()->json([
            'message' => 'تم تعديل بيانات الصورة',
            'data'    => $image
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
