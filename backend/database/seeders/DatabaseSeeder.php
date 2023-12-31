<?php
declare(strict_types=1);
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->call([
            CarMarkSeeder::class,
            CarModelSeeder::class,
            CarSeeder::class,
        ]);
    }
}
