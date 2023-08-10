<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;


//Authenticated APIS
Route::group(["middleware" => "auth:api"], function(){
    Route::group(["prefix" => "user"], function(){
        Route::post("logout", [AuthController::class, "logout"]);
        Route::post("refresh", [AuthController::class, "refresh"]);
       
         Route::get("follow/{id?}", [UserController::class, "follow"]);
         Route::get("unfollow/{id?}", [UserController::class, "unfollow"]);
         Route::post("add_post", [PostController::class, "addPost"]);
         Route::get("like/{id?}", [PostController::class, "likePost"]);
         Route::get("unlike/{id?}", [PostController::class, "unlikePost"]);

     
    });

    Route::get("search/{keyword?}", [UserController::class, "searchUser"]);
    Route::get("posts/{id?}", [PostController::class, "getPosts"]);

   
});

//Unauthenticated APIS
Route::group(["prefix" => "guest"], function(){
    //catch api for unauthorized users
    // Route::get("unauthorized", [AuthController::class, "unauthorized"])->name("unauthorized");
    //login & signup 
    Route::post("login", [AuthController::class, "login"]);
    Route::post("register", [AuthController::class, "register"]);
});


