<?php
declare(strict_types=1);

namespace App\Models;

use App\PetStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static find(int $id)
 * @method static create(array $all)
 * @method static whereIn(string $string, string[] $statuses)
 */
final class Pet extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'status',
        'photo_urls',
    ];

    protected $casts = [
        'status' => PetStatus::class,
        'photo_urls' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'pet_tag');
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['status'] = $this->status->value;

        return $array;
    }
}
