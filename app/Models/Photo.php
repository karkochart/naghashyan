<?php

namespace App\Models;

use App\Observers\PhotoObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([PhotoObserver::class])]
class Photo extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $fillable = [
        'product_id',
        'path',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
