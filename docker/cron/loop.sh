#!/usr/bin/env bash
    while [ true ]
    do
      php artisan schedule:run --verbose --no-interaction &
      sleep 55
    done
set -e
