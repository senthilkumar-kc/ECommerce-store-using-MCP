<?php


use Illuminate\Support\Facades\Route;
use SK\Demo\Facades\Demo;


Route::get('/sk-demo', function () {
return Demo::hello();
});