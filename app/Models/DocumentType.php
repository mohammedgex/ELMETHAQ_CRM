<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;
    protected $fillable = ['file', 'document_type', 'status', 'note', 'customer_id', 'required', 'order_status'];
    public function fileTitle()
    {
        return $this->belongsTo(FileTitle::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
