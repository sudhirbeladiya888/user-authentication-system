<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\Http\Controllers';

    /** @var string $apiNamespace */
    protected $apiNamespace ='App\Http\Controllers\Api';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $this->routes(function () {
            // Route::prefix('api')
            //     ->middleware('api')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/api.php'));
            Route::group([
                'middleware' => ['api', 'api_version:v1','log.activities:v1'],
                'namespace'  => "{$this->apiNamespace}\V1",
                'prefix'     => 'api/v1',
            ], function ($router) {
                require base_path('routes/api_v1.php');
            });
            Route::group([
                'middleware' => ['api', 'api_version:v2'], // 'throttle:1,1'
                'namespace'  => "{$this->apiNamespace}\V2",
                'prefix'     => 'api/v2',
            ], function ($router) {
                require base_path('routes/api_v2.php');
            });

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            // https://laravel.com/docs/8.x/routing#rate-limiting
            // return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
            return Limit::perMinute(30)->by(optional($request->user())->id ?: $request->ip())->response(function () {
               return response()->json([
                    'success'  => false,
                    'message'   => 'Too many attempts, please slow down the request.'
                ],429);
            });
        });
    }
}
