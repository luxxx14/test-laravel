<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
  public function map()
  {
    $this->mapWebRoutes();
    $this->mapApiRoutes();
  }

  protected function mapWebRoutes()
  {
    Route::middleware('web')
        ->group(base_path('routes/web.php'));
  }

  protected function mapApiRoutes()
  {
    Route::prefix('api')
        ->group(base_path('routes/api.php'));
  }
}
