<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ActivityController;

Route::middleware('api_key')->prefix('api')->group(function () {

    // Здания
    Route::get('/buildings', [BuildingController::class, 'index']);

    // Деятельности
    Route::get('/activities', [ActivityController::class, 'index']);

    // Организации
    Route::get('/organizations/building/{buildingId}', [OrganizationController::class, 'getOrganizationsByBuilding']);
    Route::get('/organizations/activity/{activityId}', [OrganizationController::class, 'getOrganizationsByActivity']);
    Route::get('/organizations/radius', [OrganizationController::class, 'getOrganizationsInRadius']);
    Route::get('/organizations/{id}', [OrganizationController::class, 'getOrganizationById']);
    Route::get('/organizations/search', [OrganizationController::class, 'searchOrganizationsByName']);
    Route::get('/organizations/activity/tree/{activityId}', [OrganizationController::class, 'searchOrganizationsByActivity']);

});
