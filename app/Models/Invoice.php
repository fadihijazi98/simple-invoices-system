<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'status',
        'store_id'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
