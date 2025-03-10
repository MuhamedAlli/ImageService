<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UploadImageRequest;
class ImageController extends Controller
{
    protected $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }


    public function upload(UploadImageRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                $result = $this->imageService->uploadImage(
                    $request->file('image'),
                    $validatedData['user_id']
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully',
                    'data' => $result
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Image upload failed'
            ], 400);
        }
    }

    public function getByUserId($user_id)
    {
            $result = $this->imageService->getImagesByUserId($user_id);
            return response()->json([
                'success' => true,
                'message' => 'Images retrieved successfully',
                'data' => $result
            ], 200);
    }

    public function deleteByUserId($user_id)
    {
        try {
            $result = $this->imageService->deleteImage($user_id);
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully',
                'data' => $result
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => "Image delete failed",
                'errors' => $e->getMessage()
            ], 400);
        }
    }
}
