<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari konvensi
    protected $table = 'products';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'product',
        'description',
        'harga',
        'foto',
    ];

    protected $primaryKey = 'id_product';

    // Jika Anda menggunakan timestamps (created_at dan updated_at)
    public $timestamps = true;
}
