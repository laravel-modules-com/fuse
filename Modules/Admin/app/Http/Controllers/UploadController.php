<?php

declare(strict_types=1);

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'upload' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // Adjust the allowed image file types and maximum size as needed
            ],
        ]);

        if ($request->hasFile('upload')) {

            $file = $request->file('upload');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $name = Str::slug(date('Y-m-d-h-i-s').'-'.pathinfo($originalName, PATHINFO_FILENAME));
            $image = Image::make($file);

            $imageString = $image->stream()->__toString();
            $name = "$name.$extension";

            Storage::disk('images')
                ->put('posts/'.$name, $imageString);

            return response()->json([
                'url' => "/images/posts/$name",
            ]);

        }

        return response()->json([
            'error' => 'No file was uploaded',
        ], 400);
    }
}
