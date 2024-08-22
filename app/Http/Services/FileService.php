<?php

namespace App\Http\Services;

use App\Exceptions\IncorrectPhotoNumberException;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    public function uploadFile($file, $fileName = '')
    {
        if (!$fileName) {
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        }

        // Store the file in the 'public' disk (you can configure other disks as needed)
        Storage::disk('public')->putFileAs('uploads', $file, $fileName);

        // Return the file path for future use (e.g., storing in the database)
        return 'uploads/' . $fileName;
    }

    public function uploadFiles($photos, array $files): array
    {
        if (count($photos) !== count($files)) {
            throw new IncorrectPhotoNumberException();
        }
        $result = [];
        foreach ($photos as $index => $photo) {
            $result[] = $this->uploadFile($files[$index], $photo->path);
        }
        return $result;
    }

    public function delete(Photo $photo): bool
    {
        return unlink(storage_path('app/public/uploads/' . $photo->path));
    }
}
