#!/bin/bash

docker build -t php-composer:8.1 .docker/php && docker run -e CACHE_DRIVER=array  --rm -it --init --network workspace -w /var/www -v ${PWD}:/var/www:delegated php-composer:8.1 $@
