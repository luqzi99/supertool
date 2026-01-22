<?php

use App\Http\Controllers\ToolsController;
use App\Tools\WhatsappLink\GenerateWhatsappLinkController;
use App\Tools\WebsitePing\CheckWebsiteController;
use App\Tools\Base64EncoderDecoder\Base64Controller;
use App\Tools\JsonFormatter\JsonFormatterController;
use App\Tools\ImageConverter\ImageConverterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tools', [ToolsController::class, 'index'])
    ->name('tools.index');

Route::get('/tools/whatsapp-link', [GenerateWhatsappLinkController::class, 'show'])
    ->name('whatsapp-link.show');

Route::post('/tools/whatsapp-link', [GenerateWhatsappLinkController::class, 'generate'])
    ->name('whatsapp-link.generate');

Route::get('/tools/website-ping', [CheckWebsiteController::class, 'show'])
    ->name('tools.website-ping.show');

Route::post('/tools/website-ping', [CheckWebsiteController::class, 'check'])
    ->name('tools.website-ping.check');

Route::get('/tools/base64', [Base64Controller::class, 'show'])
    ->name('tools.base64.show');

Route::post('/tools/base64', [Base64Controller::class, 'process'])
    ->name('tools.base64.process');

Route::get('/tools/json-formatter', [JsonFormatterController::class, 'show'])
    ->name('tools.json-formatter.show');

Route::post('/tools/json-formatter', [JsonFormatterController::class, 'process'])
    ->name('tools.json-formatter.process');

Route::get('/tools/image-converter', [ImageConverterController::class, 'index'])
    ->name('tools.image-converter.index');

Route::post('/tools/image-converter', [ImageConverterController::class, 'convert'])
    ->name('tools.image-converter.convert');
