<?php

return [
	'app_mode'   => env('MP_INTEGRATION_MODE', 'transparent'),

	// Default mode credentials
	'app_id'     => env('MP_APP_ID', ''),
	'app_secret' => env('MP_APP_SECRET', ''),

	// Transparent mode credentials
	'app_public_key' => env('MP_PUBLIC_KEY', ''),
	'app_access_token' => env('MP_ACCESS_TOKEN', '')
];