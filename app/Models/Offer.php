<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;


class Offer extends Model
{
    use HasFactory ,Cachable;

    protected $table = 'offers';
    protected $fillable = ['off','finish','product_id'];
    protected $visible=['off','finish','product'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
