<?php

Route::filter('before', function() {
            
        });

Route::filter('after', function($response) {
            // Do stuff after every request to your application...
        });

Route::filter('csrf', function() {
            if (Request::forged())
                return Response::error('500');
        });

Route::filter('auth', function() {
            if (Auth::guest())
                return Redirect::to_route('loginuser');
        });

Route::filter('authmahasiswa', function() {
            if (Auth::guest() || Auth::user()->role != 3)
                return Redirect::to_route('loginuser');
        });

Route::filter('authdosen', function() {
            if (Auth::guest() || Auth::user()->role != 2)
                return Redirect::to_route('loginuser');
        });

Route::filter('authadmin', function() {
            if (Auth::guest() || Auth::user()->adm != 1)
                return Redirect::to_route('loginadmin');
        });