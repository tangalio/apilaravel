<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $fillable =[
        'status',
        'supplier_id',
        'createby',
        'createdate',
        'deletedby',
        'deletedate'
    ];
}
