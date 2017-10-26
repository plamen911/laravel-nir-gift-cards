<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Custom Validation for CreditCard is Expired or Not
        Validator::extend('expires', function ($attribute, $value, $parameters, $validator) {
            $input = $validator->getData();

            $expiryDate = gmdate('Ym', gmmktime(0, 0, 0, (int)array_get($input, $parameters[0]), 1, (int)array_get($input, $parameters[1])));

            return $expiryDate > gmdate('Ym');
        });

        // Custom Validation for CreditCard is Valid or Not
        Validator::extend('validateluhn', function ($attribute, $value, $parameters) {
            $TEST_CREDIT_CARD = (isset($parameters[0])) ? $parameters[0] : '';
            if (!empty($TEST_CREDIT_CARD) && $TEST_CREDIT_CARD === $value) return true;

            $str = '';
            foreach (array_reverse(str_split($value)) as $i => $c) {
                $str .= $i % 2 ? $c * 2 : $c;
            }

            return array_sum(str_split($str)) % 10 === 0;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
