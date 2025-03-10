<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'user_id' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'image.required' => 'The image file is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image must not exceed 5MB.',
            'user_id.required' => 'The user ID is required.',
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
        {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(
                response()->json([
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422)
            );  
        }
}
