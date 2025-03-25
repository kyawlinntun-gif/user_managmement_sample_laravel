<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

/**
 * Class ProductService
 */
class ProductService
{
    /**
     * Store the uploaded image nad return the image name.
     *
     * @param UploadedFile|null $image
     * @return string
     */
    public function store(UploadedFile $image = null): string
    {
        $imageName = '1739379536placeholder.png';
        if ($image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/upload'), $imageName);
        }
        return $imageName;
    }
}
