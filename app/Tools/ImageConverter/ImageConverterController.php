<?php

namespace App\Tools\ImageConverter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageConverterController extends Controller
{
    public function index()
    {
        return view('tools.image-converter');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,webp,gif|max:10240',
            'format' => 'required|in:jpeg,png,webp,gif',
            'quality' => 'nullable|integer|min:1|max:100',
            'width' => 'nullable|integer|min:1|max:5000',
            'height' => 'nullable|integer|min:1|max:5000',
        ]);

        $file = $request->file('image');
        $targetFormat = $request->input('format');
        $quality = $request->input('quality', 90);
        
        // Load image
        $imageString = file_get_contents($file->getRealPath());
        $image = \imagecreatefromstring($imageString);
        
        if (!$image) {
            return response()->json(['error' => 'Unable to process image'], 422);
        }

        // Handle transparency for PNG/WEBP
        \imagepalettetotruecolor($image);
        if (in_array($targetFormat, ['png', 'webp'])) {
            \imagealphablending($image, false);
            \imagesavealpha($image, true);
        }

        // Resize if needed
        $width = $request->input('width');
        $height = $request->input('height');
        
        if ($width || $height) {
            $currentWidth = \imagesx($image);
            $currentHeight = \imagesy($image);
            
            $newWidth = $width ?? ($currentWidth * ($height / $currentHeight));
            $newHeight = $height ?? ($currentHeight * ($width / $currentWidth));
            
            $resized = \imagescale($image, (int)$newWidth, (int)$newHeight);
            \imagedestroy($image);
            $image = $resized;
            
             // Re-apply transparency settings after resize
            if (in_array($targetFormat, ['png', 'webp'])) {
                \imagealphablending($image, false);
                \imagesavealpha($image, true);
            }
        }

        // Buffer output
        ob_start();

        switch ($targetFormat) {
            case 'jpeg':
                // Fill background with white for JPEG transparency
                $bg = \imagecreatetruecolor(\imagesx($image), \imagesy($image));
                \imagefill($bg, 0, 0, \imagecolorallocate($bg, 255, 255, 255));
                \imagecopy($bg, $image, 0, 0, 0, 0, \imagesx($image), \imagesy($image));
                \imagejpeg($bg, null, $quality);
                \imagedestroy($bg);
                break;
            case 'png':
                // PNG compression (0-9)
                $compression = 6; // default
                \imagepng($image, null, $compression);
                break;
            case 'webp':
                \imagewebp($image, null, $quality);
                break;
            case 'gif':
                \imagegif($image);
                break;
        }

        $content = ob_get_clean();
        \imagedestroy($image);

        $filename = 'converted_' . Str::random(10) . '.' . ($targetFormat === 'jpeg' ? 'jpg' : $targetFormat);

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $filename, [
            'Content-Type' => 'image/' . $targetFormat,
        ]);
    }
}
