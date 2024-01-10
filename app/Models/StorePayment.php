<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_number',
        'gift_card_number',
        'balance',
    ];
}
