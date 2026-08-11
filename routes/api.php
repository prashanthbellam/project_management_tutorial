<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenceMasterController;

Route::apiResource('licence-master', LicenceMasterController::class);
