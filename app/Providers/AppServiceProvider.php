<?php

namespace App\Providers;

use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Validator::extend('valor_tablero', function ($attribute, $value, $parameters, $validator) {
				if (in_array(strtr(array_get($validator->getData(), 'indicador'), array("." => "|")), ['5|1', '5|3'])) {
					try {
						$d = DateTime::createFromFormat('d/m/Y', $value);
						if (!$d) {
							return false;
						}
						return checkdate($d->format('m'), $d->format('d'), $d->format('Y'));
					} catch (\Exception $e) {
						return false;
					}
				} else {
					return true;
				}

			}, 'El campo no cumple con el formato para este indicador');
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
