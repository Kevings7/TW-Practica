<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('Vaquillofreila', function () {
    $this->comment('Bácor Manda');
})->purpose('Demostrar quien manda');