<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DollarValue extends Model
{
    use HasFactory;

    protected $table = 'dollar_values';

    protected $fillable = [
        'date',
        'value',
        'source'
    ];

    protected $casts = [
        'date',
        'value'
    ];


    public $timestamps = true;
}
