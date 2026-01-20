<?php

use App\Http\Controllers\ToolsController;
use App\Tools\WhatsappLink\GenerateWhatsappLinkController;
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
