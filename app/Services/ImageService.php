<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    public function store(UploadedFile $image, string $directory, string $disk = 's3'): string
    {
        return $image->store($directory, $disk);
    }

    public function storeMultiple(array $images, string $directory, string $disk = 's3'): array
    {
        return array_map(fn($image) => $this->store($image, $directory, $disk), $images);
    }
}
