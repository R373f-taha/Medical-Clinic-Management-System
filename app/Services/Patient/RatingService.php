<?php

namespace App\Services\Patient;

use App\Models\Rating;

class RatingService
{
    public function getAll()
    {
        return Rating::latest()->get();
    }

    public function store(array $data)
    {
        return Rating::create($data);
    }

    public function update(Rating $rating, array $data)
    {
        $rating->update($data);
        return $rating;
    }

    public function delete(Rating $rating)
    {
        return $rating->delete();
    }
}