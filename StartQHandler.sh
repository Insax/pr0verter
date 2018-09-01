#!/bin/bash

Q_BIN="php artisan queue:work --queue=convert,download --tries=2"

    while x=1;
    do
	$Q_BIN
	sleep 1
    done
