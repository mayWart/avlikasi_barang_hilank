<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Kolom yang diizinkan untuk diisi
    protected $fillable = [
        'user_id', 'type', 'category', 'item_name', 'description', 'image_path', 'wa_number', 'status'
    ];

    // Relasi: 1 Postingan dimiliki oleh 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}