<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'client_name',
        'image',
        'category_id',
        'description',
    ];

    /**
     * Get the category that owns the portfolio item.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
