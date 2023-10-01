<?php
declare(strict_types=1);
namespace Database\Seeders;

use App\Domain\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public const CARS = [
        [
            'car_id'   => '784a603d-25fc-b64f-4a9e-28ce5331ac12',
            'name'     => 'Мэрс',
            'model_id' => 'd60206f7-304f-4d72-bcfc-9fec3b8a814c',
            'year'     => 2023,
            'mileage'  => 20,
            'color'    => 'черный',

        ],
        [
            'car_id'   => '5419db1e-657a-4847-c23f-a154321b0a27',
            'name'     => 'Ренуха',
            'model_id' => '908d1fa7-428d-45cf-af08-dbdce9a47712',
            'year'     => 1913,
            'mileage'  => 10000000,
            'color'    => 'красный',
        ],
    ];

    /**
     * @return void
     */
    public function run(): void
    {
        Car::truncate();
        Car::insert(self::CARS);
    }
}
