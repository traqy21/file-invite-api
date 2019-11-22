<?php

namespace App\Providers;

use App\Models\Item;
use App\Observers\ItemObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider {

    public function boot() {
        \date_default_timezone_set('Asia/Manila');

        Item::observe(ItemObserver::class);
        //validators
        Validator::extend('uuid', function ($attribute, $value, $parameters, $validator) {
            return \Ramsey\Uuid\Uuid::isValid($value);
        });

        Validator::extend('is_base64_pdf', function ($attribute, $value, $parameters, $validator) {

            if ($value != null && $value != '' && $value != 'null') {

                $image = base64_decode($value);
                $f = finfo_open();
                $result = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
                return str_contains($result, 'application/pdf');
            }

            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
