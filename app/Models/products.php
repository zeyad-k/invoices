<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sections; // Import the missing class

class products extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'product_name',
    //     'section_id',
    //     'description',
    // ];
    protected $guarded;

    public function section()
    {
        return $this->belongsTo(sections::class); // Use the imported class
    }
}
