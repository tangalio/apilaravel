<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'invoicedetail';
    protected $filable=[
        'invoice-id',
        'product_id',
        'quantity'
    ];
}
