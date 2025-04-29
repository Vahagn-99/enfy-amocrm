#!/bin/bash

# restart php
sudo systemctl restart php8.4-fpm

# Laravel optimizations
php artisan optimize:clear
php artisan optimize
php artisan flush:redis

# Run custom npm process
npm run processes:run
