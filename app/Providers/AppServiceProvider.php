<?php

namespace App\Providers;

use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Validator::extend('valor_tablero', function ($attribute, $value, $parameters, $validator) {
				Log::info($validator->getData());
				if (in_array(array_get($validator->getData(), 'indicador'), ['5.1', '5.3'])) {
					$d = DateTime::createFromFormat('d/m/Y', '5/9/2017');
					return checkdate($d->format('m'), $d->format('d'), $d->format('Y'));
				} else {
					return is_numeric($value);
				}

			});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		if ($this->app->environment() !== 'production') {
			$this->app->register(\Sven\ArtisanView\ServiceProvider::class );
		}
	}
}
