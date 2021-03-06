<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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
})->purpose('Display an inspiring quote');


Artisan::command('configure', function () {
   Artisan::call('migrate:fresh');
    $this->comment("Migration completed");

     User::create([
        "name" => "Uzor Mercy",
        "email" => "mercy@example.com",
        "password" => bcrypt("password")
    ]);
    $this->comment("Default User created successfully");

    Artisan::call('passport:install --force');
        $this->comment("Passport created successfully");

});
