<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('add_vk', function () {
    $vk = new \App\Social();
    $vk->type = "vk";
    $vk->auth_url = "https://oauth.vk.com/authorize";
    $vk->secret_id = "7202629";
    $vk->secret_key = "mSx5TnDRlSF0EISbF85V";
    $vk->service_key = "0a3f57e40a3f57e40a3f57e4ac0a52b0a100a3f0a3f57e457f9bbd6f9aa58491151ed9f";
    $vk->save();

    echo "DONE \n";
});
