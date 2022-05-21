<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'uuid';
    protected $fillable = ["user_id", "title", "status", "description", "others", "category"];
    public $incrementing = false;
    public function user ()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    protected $casts = [
        'id' => 'string'
    ];
}
