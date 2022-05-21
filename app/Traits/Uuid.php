<?php
    namespace App\Traits;
    use Illuminate\Support\Str;


    trait Uuid
    {
        protected static function boot()
        {
            parent::boot();
            static::creating(function ($model) {
                try {
                    $model->id = (string) Str::uuid();
                } catch (\Throwable $th) {
                    abort(500, $th->getMessage());
                }
            });
        }
    }
