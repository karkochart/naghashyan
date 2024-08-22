<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeletePhotoRequest;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;

class PhotoController extends Controller
{


    public function destroy(DeletePhotoRequest $request): array
    {

        $photo = Photo::where('id', $request->get('id'))->get()->first();
        $photo->delete();

        return PhotoResource::make($photo)->resolve();
    }
}
