<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'generated_content',
        'template',
    ];

    protected $casts = [
        'generated_content' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
