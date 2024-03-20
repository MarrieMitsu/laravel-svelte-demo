<?php

use App\Http\Controllers\Pages\Contact;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Contact::class, 'view'])->name('Contact.view');
Route::post('/contact', [Contact::class, 'createContact'])
    ->name('Contact.createContact');
Route::put('/contact/{id}', [Contact::class, 'updateContact'])
    ->name('Contact.updateContact');
Route::delete('/contact/{id}', [Contact::class, 'deleteContact'])
    ->name('Contact.deleteContact');
Route::post('/seed-contact', [Contact::class, 'seedContact'])
    ->name('Contact.seedContact');
