<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhoneBookController;


Route::get('/', function () {
    return view('contacts.index');
});
Route::resource('contacts', PhoneBookController::class);
