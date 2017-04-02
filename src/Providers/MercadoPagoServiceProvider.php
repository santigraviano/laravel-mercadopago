<?php

namespace SantiGraviano\LaravelMercadoPago\Providers;

use Illuminate\Support\ServiceProvider;
use SantiGraviano\LaravelMercadoPago\MP;

class MercadoPagoServiceProvider extends ServiceProvider 
{
	protected $mp_app_mode;

	protected $mp_app_id;
	protected $mp_app_secret;

	protected $mp_app_public_key;
	protected $mp_app_access_token;

	public function boot()
	{
		
		$this->publishes([__DIR__.'/../config/mercadopago.php' => config_path('mercadopago.php')]);

		$this->mp_app_id     = config('mercadopago.app_id');
		$this->mp_app_secret = config('mercadopago.app_secret');

		$this->mp_app_public_key = config('mercadopago.app_public_key');
		$this->mp_app_access_token = config('mercadopago.app_access_token');
	}

	public function register()
	{
		$this->app->singleton('MP', function(){
			if ($this->mp_app_mode == 'transparent') {
				return new MP($this->mp_app_access_token);
			} else {
				return new MP($this->mp_app_id, $this->mp_app_secret);
			}
		});
	}
}