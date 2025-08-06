<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ActivityController;

use App\Http\Middleware\CheckApiKeyMiddleware;

Route::middleware(CheckApiKeyMiddleware::class)->group(function () {
  Route::get('/buildings', [BuildingController::class, 'index']);

  Route::get('/activities', [ActivityController::class, 'index']);

  Route::get('organizations/building/{building_id}', [OrganizationController::class, 'getOrganizationsByBuilding']);
  Route::get('organizations/activity/{activity_id}', [OrganizationController::class, 'getOrganizationsByActivity']);
  Route::get('organizations/nearby', [OrganizationController::class, 'getOrganizationsNearby']);
  Route::get('organizations/{id}', [OrganizationController::class, 'show']);
  Route::get('organizations/search/name/{name}', [OrganizationController::class, 'searchByName']);
  Route::get('organizations/search/activity/{activity_name}', [OrganizationController::class, 'searchByActivity']);
});
