<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;
    protected $fillable = ['file', 'document_type', 'status', 'note', 'customer_id'];
    public function fileTitle()
    {
        return $this->belongsTo(FileTitle::class);
    }
    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }
}
