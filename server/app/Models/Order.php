<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'description', 'user_id', 'tel', 'fullname', 'photo',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}