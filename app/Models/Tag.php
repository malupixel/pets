<?php
declare(strict_types=1);

namespace App\Models;

use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static find(int $id)
 * @method static create(array $all)
 */
final class Tag extends Model
{
    /** @use HasFactory<TagFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function pets(): BelongsToMany
    {
        return $this->belongsToMany(Pet::class, 'pet_tag');
    }
}
