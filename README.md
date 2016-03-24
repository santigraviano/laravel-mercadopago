# Laravel Facade para MercadoPago v0.5.2

* [Instalación](#install)
* [Configuración](#configuration)
* [Como utilizar](#how-to)

<a name="install"></a>
### Instalación

`composer require santigraviano/laravel-mercadopago`

Dentro de `config/app.php` agregar los siguientes Provider y Alias

Provider

```php
'providers' => [
  // Otros Providers...
  SantiGraviano\LaravelMercadoPago\Providers\MercadoPagoServiceProvider::class,
  /*
   * Application Service Providers...
   */
],
```

Alias

```php
'aliases' => [
  // Otros Aliases
  'MP' => SantiGraviano\LaravelMercadoPago\Facades\MP::class,
],
```

<a name="configuration"></a>
### Configuración

Antes de configurar el APP ID y APP SECRET, ejecutar el siguiente comando: 

`php artisan vendor:publish`

Despues de haber ejecutado el comando, ir al archivo `.env` y agregar los campos `MP_APP_ID` y `MP_APP_SECRET` con los correspondientes valores de los `CLIENT_ID` y `CLIENT_SECRET` de tu aplicacion de MercadoPago.

Para saber cuales son tus datos `CLIENT_ID` y `CLIENT_SECRET` podes ingresar aqui, dependiendo de tu país: 

* [Argentina](https://www.mercadopago.com/mla/herramientas/aplicaciones)
* [Brazil](https://www.mercadopago.com/mlb/ferramentas/aplicacoes)
* [Mexico](https://www.mercadopago.com/mlm/herramientas/aplicaciones)
* [Venezuela](https://www.mercadopago.com/mlv/herramientas/aplicaciones)
* [Colombia](https://www.mercadopago.com/mco/herramientas/aplicaciones)
* [Chile](https://www.mercadopago.com/mlc/herramientas/aplicaciones)

Si no deseas usar el archivo `.env`, ir a `config/mercadopago.php` y agregar tus datos de aplicación correspondientes.

```php
return [
	'app_id'     => env('MP_APP_ID', 'TU CLIENT ID AQUI'),
	'app_secret' => env('MP_APP_SECRET', 'TU CLIENT SECRET AQUI')
];
```

<a name="how-to"></a>
### Como utilizar

En este ejemplo vamos a crear una preferencia de pago, usando la Facade `MP` 

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use MP;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MercadoPagoController extends Controller
{
  public function getCreatePreference()
  {
  	$preferenceData = [
  		'items' => [
  			[
  				'id' => 12,
  				'category_id' => 'phones',
  				'title' => 'iPhone 6',
  				'description' => 'iPhone 6 de 64gb nuevo',
  				'picture_url' => 'http://d243u7pon29hni.cloudfront.net/images/products/iphone-6-dorado-128-gb-red-4g-8-mpx-1256254%20(1)_m.png',
  				'quantity' => 1,
  				'currency_id' => 'ARS',
  				'unit_price' => 14999
  			]
  		],
  	];

  	$preference = MP::create_preference($preferenceData);

  	return dd($preference);

  }
```

En este ejemplo vamos a crear una subscripción (débito automático), usando la Facade `MP` 

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use MP;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MercadoPagoController extends Controller
{
  public function getCreatePreapproval()
  {
    $preapproval_data = [
      'payer_email' => 'agariobadcell@gmail.com',
      'back_url' => 'http://labhor.com.ar/laravel/public/preapproval',
      'reason' => 'Subscripción a paquete premium',
      'external_reference' => $subscription->id,
      'auto_recurring' => [
        'frequency' => 1,
        'frequency_type' => 'months',
        'transaction_amount' => 99,
        'currency_id' => 'ARS',
        'start_date' => str_replace('000000', '000', Carbon::now()->addHour()->format('Y-m-d\TH:i:s.uP')),
        'end_date' => str_replace('000000', '000', Carbon::now()->addMonth()->format('Y-m-d\TH:i:s.uP')),
      ],
    ];

    MP::create_preapproval_payment($preapproval_data);

    return dd($preapproval);
  }
```

En el ejemplo se puede ver el uso de la libreria `Carbon`, para especificar la fecha de comienzo de la subscripción y el termino de la misma, siendo de frecuencia mensual.

A la fecha actual, via `Carbon` se le agrega una hora, ya que de otra manera MercadoPago puede dar la fecha como pasada.

Ademas se reemplazan los `000000`  por `000` para que el formato sea aceptado por MercadoPago