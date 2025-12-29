<?php

namespace App\Services\Patient;

use App\Models\Image;

class ImageService
{
    public function getAll()
    {
        return Image::latest()->get();
    }

    public function store(array $data)
    {
        return Image::create($data);
    }

    public function update(Image $image, array $data)
    {
        $image->update($data);
        return $image;
    }

    public function delete(Image $image)
    {
        return $image->delete();
    }
}