<?php

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/search', function (Request $request) {
    return app('schools')->search(
        $request->validate(['q' => 'required|string|max:255'])['q']
    );
});
