<?php

namespace SantiGraviano\LaravelMercadoPago\Providers;

use Illuminate\Support\ServiceProvider;
use SantiGraviano\LaravelMercadoPago\MP;

class MercadoPagoServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->singleton('MP', function(){
			return new MP();
		});
	}
}