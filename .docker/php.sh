#!/bin/bash

docker run -e CACHE_DRIVER=array  --rm -it --init --network workspace -w /var/www -v ${PWD}:/var/www:delegated php:8.1 $@
