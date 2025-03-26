<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('api', function (bool $status, string $message = '', $data = null, int $code = 200) {
            $response = [
                'status' => $status,
                'message' => $message,
            ];

            if ($data) {
                $response['data'] = $data;
            }
            return Response::json($response, $code);
        });
    }
}
