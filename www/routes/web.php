<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/docs/api/json/v1', function () {
    $openapi = \OpenApi\Generator::scan(['../app/Http']);

    header('Content-Type: application/x-yaml');
    echo $openapi->toYaml();
});

