<?php
declare(strict_types=1);
namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class CarModel extends Model
{
    /**
     * @return BelongsTo
     */
    public function mark(): BelongsTo
    {
        return $this->belongsTo(CarMark::class, 'mark_id', 'mark_id');
    }
}
