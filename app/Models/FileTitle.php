<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileTitle extends Model
{
    use HasFactory;
    protected $fillable = ['title'];
    public function documentTypes() { return $this->hasMany(DocumentType::class); }
}
