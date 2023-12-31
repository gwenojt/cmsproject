<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  
        'category',
        'filename',
        'status',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
