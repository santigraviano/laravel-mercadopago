<?php

namespace SantiGraviano\LaravelMercadoPago\Facades;

use Illuminate\Support\Facades\Facade;

/**
* Mercado Pago SDK Facade
*/
class MP extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'MP';
	}
}

