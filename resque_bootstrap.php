<?php
 
// Bootstrap the laravel environment for our resque workers.
require 'paths.php';
require path('sys').'core.php';
 
Laravel\Bundle::start(DEFAULT_BUNDLE);
 
\Autoloader::directories(array(
   path('app').'workers',
));
 
/*
|----------------------------------------------------------------
| Application Environment
|----------------------------------------------------------------
|
| When calling the resque.php from the CLI we can specify the
| environment to use. This is done with ENV=environment. This is
| always required.
|
| IE: ENV=development php resque.php
|
*/
 
$env = getenv('ENV');
 
if(empty($env))
{
    die("Set ENV env var with the Laravel environtment to use.\n");
}
 
Request::set_env($env);
