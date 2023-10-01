<?php
declare(strict_types=1);
namespace Database\Seeders;

use App\Domain\Models\CarMark;
use Illuminate\Database\Seeder;

class CarMarkSeeder extends Seeder
{
    public const MARKS = [
        ['mark_id' => '954b60a4-13ee-4fb6-9e4a-044bd251fe88', 'name' => 'Mercedes-Benz'],
        ['mark_id' => '8349b905-63f7-4454-b93b-c010252c0ac4', 'name' => 'Renault'],
        ['mark_id' => '83713ea6-a523-4fbc-8384-babf0646abe8', 'name' => 'Toyota'],
    ];

    /**
     * @return void
     */
    public function run(): void
    {
        CarMark::truncate();
        CarMark::insert(self::MARKS);
    }
}
