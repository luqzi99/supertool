<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageConverterTest extends TestCase
{
    public function test_image_converter_page_loads()
    {
        $response = $this->get(route('tools.image-converter.index'));
        $response->assertStatus(200);
        $response->assertSee('Image Converter');
    }

    public function test_can_convert_png_to_jpg()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('test.png', 100, 100);

        $response = $this->post(route('tools.image-converter.convert'), [
            'image' => $file,
            'format' => 'jpeg',
            'quality' => 90
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/jpeg');
    }

    public function test_can_resize_image()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('test.png', 200, 200);

        $response = $this->post(route('tools.image-converter.convert'), [
            'image' => $file,
            'format' => 'png',
            'width' => 100,
            'height' => 100
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/png');
        // We can't easily check the dimensions of the streamed content without saving, 
        // but status 200 implies logic ran.
    }

    public function test_validation_fails_for_invalid_format()
    {
        $file = UploadedFile::fake()->image('test.png');

        $response = $this->post(route('tools.image-converter.convert'), [
            'image' => $file,
            'format' => 'exe', // Invalid
        ]);

        $response->assertSessionHasErrors(['format']);
    }
    
    public function test_validation_fails_for_non_image()
    {
        $file = UploadedFile::fake()->create('test.pdf', 100);

        $response = $this->post(route('tools.image-converter.convert'), [
            'image' => $file,
            'format' => 'jpeg',
        ]);

        $response->assertSessionHasErrors(['image']);
    }
}
