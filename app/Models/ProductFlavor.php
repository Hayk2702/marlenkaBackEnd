<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFlavor extends Model
{
    use HasFactory;

    public function flavor(){
        return $this->hasOne(Flavor::class,"id","flavor_id");
    }
}
