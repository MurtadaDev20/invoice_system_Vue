<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;
    protected $fillable = [
        'total',
        'customer_id',
        'sub_total',
        'date',
        'due_date',
        'reference',
        'discount',
        'number',
        'terms_and_conditions',
    ];
    public function customer(){
        return $this->belongsTo(Customers::class);
    }

    public function invoices_items(){
        return $this->hasMany(InvoicesItem::class,'invoice_id');
    }
}
