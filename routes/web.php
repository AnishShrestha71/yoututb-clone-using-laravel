<?php

use App\Http\Controllers\Channel;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UploadVideoController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VoteController;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/Channel/{id}',[Channel::class,'show'])->name('channel');
Route::put('/UpdateChannel/{id}',[Channel::class,'update'])->name('update.channel')->middleware(['auth']);
Route::post('/channel/{channel}/subscription',[SubscriptionController::class,'store'])->name('subscribe');
Route::delete('/channel/{channel}/subscription/{subscription}',[SubscriptionController::class,'delete'])->name('unssubscribe');
Route::get('/upload/{channel}',[UploadVideoController::class,'show'])->name('upload.channel');
Route::post('/uploads/{channel}',[UploadVideoController::class,'store']);
Route::get('/video/{video}',[VideoController::class,'show'])->name('video.show');
Route::put('/video/{video}',[VideoController::class,'updateViews']);
Route::put('/update/video/{video}',[VideoController::class,'updateVideo'])->name('update.video');
Route::post('/votes/{video}/{type}',[VoteController::class,'vote']);
Route::delete('/votes/{entityId}/{type}',[VoteController::class,'deleteVote']);
Route::get('/video/{video}/comment',[CommentController::class,'index']);
Route::get('/comment/{comment}/reply',[CommentController::class,'show']);
Route::post('comment/{video}',[CommentController::class,'store']);