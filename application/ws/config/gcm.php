<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
|| Google Cloud Messaging Configurations
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
*/


/*
|--------------------------------------------------------------------------
| User data
|--------------------------------------------------------------------------
| Get API Key: https://code.google.com/apis/console/
*/
$config['gcm_api_key'] = 'AIzaSyBybzfvmHzYBJh-mnnhS0qj8tmFfjNnN4Y';


/*
|--------------------------------------------------------------------------
| API Send Address
|--------------------------------------------------------------------------
|
*/
$config['gcm_api_send_address'] = 'https://android.googleapis.com/gcm/send';