<?php

use App\Http\Controllers\Api\BmkgFeedController;
use App\Http\Controllers\Api\SipongiFeedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('bmkg')->group(function () {
    Route::get('/', [BmkgFeedController::class, 'index']);
    Route::get('/realtime', fn (\App\Services\BmkgFeedService $s) => app(BmkgFeedController::class)->category('realtime', $s));
    Route::get('/catalog', fn (\App\Services\BmkgFeedService $s) => app(BmkgFeedController::class)->category('catalog', $s));
    Route::get('/sensors', fn (\App\Services\BmkgFeedService $s) => app(BmkgFeedController::class)->category('sensor', $s));
    Route::get('/spatial', fn (\App\Services\BmkgFeedService $s) => app(BmkgFeedController::class)->category('spatial', $s));
    Route::get('/events/mmi', fn (\App\Services\BmkgFeedService $s) => app(BmkgFeedController::class)->show('stationlist_mmi', $s));
    Route::get('/{feed}', [BmkgFeedController::class, 'show']);
});

Route::prefix('sipongi')->group(function () {
    Route::get('/', [SipongiFeedController::class, 'index']);
    Route::get('/{feed}', [SipongiFeedController::class, 'show']);
});
