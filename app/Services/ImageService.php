<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Interfaces\ImageRepositoryInterface;

class ImageService
{
    protected $imageRepository;
    public function __construct(ImageRepositoryInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }
    public function uploadImage(UploadedFile $image, $userId)
    {
        $filenameWithExt = $image->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . '.' . $extension;

        $uploadPath = public_path('images/users');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $image->move($uploadPath, $filenameToStore);

        $imageData = [
            'img_name' => $filenameToStore,
            'user_id' => $userId
        ];

        $image = $this->imageRepository->store($imageData);

        return $image;
    }

    public function getImagesByUserId($userId)
    {
        return $this->imageRepository->getByUserId($userId);
    }

    public function deleteImage($imageId)
    {
        $image = $this->imageRepository->deleteByUserId($imageId);
        if ($image) {
            $filePath = public_path('images/users/' . $image->img_name);
            if (file_exists($filePath)) {
                unlink($filePath);
                return true;
            }
        } else {
            throw new ModelNotFoundException("Image not found.", 404);
        }
        return $image;
    }
}
