<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded;
    public function section()
    {
        return $this->belongsTo(sections::class); // Use the imported class
    }
    public function invoices_details()
    {
        return $this->belongsTo(invoices_details::class); // Use the imported class
    }
    public function invoices_attachemets()
    {
        return $this->belongsTo(invoices_details::class); // Use the imported class
    }


}
