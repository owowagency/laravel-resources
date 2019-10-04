<?php

use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;
use OwowAgency\LaravelResources\Controllers\ResourceController;

Route::resource('test-models', ResourceController::class, [
    'only' => [
        'index',
    ],
    'model' => TestModel::class,
    // 'requests' => [
    //     'store' => StoreRequest::class,
    //     'update' => UpdateRequest::class,
    // ],
]);
