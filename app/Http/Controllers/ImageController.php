<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'max:10240'],
            'quality' => ['required', 'integer', 'min:1', 'max:100'],
            'width' => ['nullable', 'integer', 'min:1'],
            'height' => ['nullable', 'integer', 'min:1'],
            'crop_width' => ['nullable', 'integer', 'min:1', 'required_with:crop_height'],
            'crop_height' => ['nullable', 'integer', 'min:1', 'required_with:crop_width'],
            'crop_x' => ['nullable', 'integer', 'min:0'],
            'crop_y' => ['nullable', 'integer', 'min:0'],
            'output_format' => ['required', 'in:jpg,png,webp'],
            'remove_background' => ['nullable', 'boolean'],
        ]);

        $file = $request->file('image');
        $originalSize = round($file->getSize() / 1024, 2);
        $imageBinary = $file->get();
        $removeBackground = $request->boolean('remove_background');

        if ($removeBackground) {
            $imageBinary = $this->removeFlatBackground($imageBinary);
        }

        $manager = new ImageManager(new Driver);
        $image = $manager->decodeBinary($imageBinary);

        $cropWidth = $request->integer('crop_width');
        $cropHeight = $request->integer('crop_height');
        $cropX = $request->integer('crop_x', 0);
        $cropY = $request->integer('crop_y', 0);

        if ($cropWidth && $cropHeight) {
            if ($cropX + $cropWidth > $image->width() || $cropY + $cropHeight > $image->height()) {
                throw ValidationException::withMessages([
                    'crop_width' => 'The crop area must fit within the image.',
                ]);
            }

            $image->crop($cropWidth, $cropHeight, $cropX, $cropY);
        }

        $width = $request->integer('width');
        $height = $request->integer('height');

        if ($width && $height) {
            $image->scaleDown(width: $width, height: $height);
        } elseif ($width) {
            $image->scaleDown(width: $width);
        } elseif ($height) {
            $image->scaleDown(height: $height);
        }

        $outputFormat = $removeBackground ? 'png' : $request->string('output_format')->toString();
        $format = Format::create($outputFormat);
        $fileName = uniqid('', true) . '.' . $outputFormat;
        $savePath = storage_path('app/public/' . $fileName);
        $quality = $request->integer('quality');

        $encodedImage = match ($format) {
            Format::JPEG, Format::WEBP => $image->encodeUsingFormat($format, quality: $quality),
            Format::PNG => $image->encodeUsingFormat($format),
        };

        $encodedImage->save($savePath);

        $newSize = round(filesize($savePath) / 1024, 2);
        $saved = $originalSize > 0 ? round((($originalSize - $newSize) / $originalSize) * 100, 2) : 0;

        return response()->json([
            'status' => true,
            'original_size' => $originalSize . ' KB',
            'compressed_size' => $newSize . ' KB',
            'saved' => $saved . '%',
            'width' => $image->width() . ' px',
            'height' => $image->height() . ' px',
            'format' => strtoupper($outputFormat),
            'preview' => asset('storage/' . $fileName),
            'download' => route('image.download', $fileName),
        ]);
    }

    public function download(string $file): mixed
    {
        $path = storage_path('app/public/' . $file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path)->deleteFileAfterSend(true);
    }

    private function removeFlatBackground(string $imageBinary): string
    {
        $source = @imagecreatefromstring($imageBinary);

        if ($source === false) {
            return $imageBinary;
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $referenceColor = imagecolorsforindex($source, imagecolorat($source, 0, 0));
        $result = imagecreatetruecolor($width, $height);

        imagealphablending($result, false);
        imagesavealpha($result, true);
        $transparent = imagecolorallocatealpha($result, 0, 0, 0, 127);
        imagefill($result, 0, 0, $transparent);

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $color = imagecolorsforindex($source, imagecolorat($source, $x, $y));
                $distance = abs($color['red'] - $referenceColor['red'])
                    + abs($color['green'] - $referenceColor['green'])
                    + abs($color['blue'] - $referenceColor['blue']);

                if ($distance < 78) {
                    continue;
                }

                $pixel = imagecolorallocatealpha($result, $color['red'], $color['green'], $color['blue'], $color['alpha']);
                imagesetpixel($result, $x, $y, $pixel);
            }
        }

        ob_start();
        imagepng($result);
        $transparentImage = (string) ob_get_clean();
        imagedestroy($source);
        imagedestroy($result);

        return $transparentImage;
    }
}
