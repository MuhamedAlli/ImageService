<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ImageRepositoryInterface;
use App\Models\Image;

class ImageRepository implements ImageRepositoryInterface
{
    public function store(array $imageData)
    {
        $updatedImage = Image::where('user_id', $imageData['user_id'])->first();
       if($updatedImage) {
            $oldImageName =$updatedImage->img_name;
            $updatedImage->img_name = $imageData['img_name'];
            $updatedImage->save();
            $filePath = public_path('images/users/' .$oldImageName);
            if (file_exists($filePath)) {
                unlink($filePath);
                return true;
            } 
            return $updatedImage;
        }

        $image = Image::create([
            'img_name' => $imageData['img_name'],
            'user_id' => $imageData['user_id'],
        ]);
        

        return $image;
    }

    public function getByUserId($user_id)
    {
        return Image::where('user_id', $user_id)->first();
    }

    public function deleteByUserId($user_id)
    {
        $image = Image::where('user_id', $user_id)->first();

        if ($image) {
            $image->delete();
        }
        return $image;
    }
}
