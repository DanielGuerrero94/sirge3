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
				if (in_array(array_get($validator->getData(), 'indicador'), ['5.1', '5.3'])) {
					try {
						$d = DateTime::createFromFormat('d/m/Y', $value);
						return checkdate($d->format('m'), $d->format('d'), $d->format('Y'));
					} catch (\Exception $e) {
						return false;
					} catch (FatalErrorException $e) {
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
		if ($this->app->environment() !== 'production') {
			$this->app->register(\Sven\ArtisanView\ServiceProvider::class );
		}
	}
}
