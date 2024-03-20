<?php

use App\Http\Controllers\Api\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('contact')->group(function () {
    Route::get('/', [Contact::class, 'getContactList']);
    Route::post('/', [Contact::class, 'createContact']);
    Route::put('/{id}', [Contact::class, 'updateContact']);
    Route::delete('/{id}', [Contact::class, 'deleteContact']);
});
