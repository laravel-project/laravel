#!/bin/sh
cd vendor/chrisboulton/php-resque
# Replace MyAppName with whatever you want to name this queue
QUEUE=Laravel APP_INCLUDE=../../../resque_bootstrap.php ENV=local php resque.php
