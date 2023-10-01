<?php
declare(strict_types=1);
namespace Database\Seeders;


use App\Domain\Models\CarModel;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    public const MODELS = [
        ['model_id' => 'd60206f7-304f-4d72-bcfc-9fec3b8a814c', 'mark_id' => '954b60a4-13ee-4fb6-9e4a-044bd251fe88', 'name' => 'C-Class'],
        ['model_id' => 'd2f8ca6a-4b02-4fac-a7ad-bcf27dab8217', 'mark_id' => '954b60a4-13ee-4fb6-9e4a-044bd251fe88', 'name' => 'E-Class'],
        ['model_id' => '87b5d48d-1992-434f-a197-30b8417b476b', 'mark_id' => '954b60a4-13ee-4fb6-9e4a-044bd251fe88', 'name' => 'G-Class'],

        ['model_id' => '908d1fa7-428d-45cf-af08-dbdce9a47712', 'mark_id' => '8349b905-63f7-4454-b93b-c010252c0ac4', 'name' => 'LOGAN'],
        ['model_id' => '7e2173ac-9e25-4cc5-8b1c-66d07a10366c', 'mark_id' => '8349b905-63f7-4454-b93b-c010252c0ac4', 'name' => 'SANDERO'],
        ['model_id' => 'a317f147-9654-4f64-ba6f-6e79f30804f4', 'mark_id' => '8349b905-63f7-4454-b93b-c010252c0ac4', 'name' => 'DUSTER'],

        ['model_id' => 'a9a2aacf-4a05-4112-9002-bb4c30948989', 'mark_id' => '83713ea6-a523-4fbc-8384-babf0646abe8', 'name' => 'Corolla'],
        ['model_id' => '8624179b-0bef-4176-a6d5-fb9096231699', 'mark_id' => '83713ea6-a523-4fbc-8384-babf0646abe8', 'name' => 'Camry'],
        ['model_id' => '6d6eb849-bf93-4468-9d85-d5ca79b91648', 'mark_id' => '83713ea6-a523-4fbc-8384-babf0646abe8', 'name' => 'RAV4'],
    ];

    /**
     * @return void
     */
    public function run(): void
    {
        CarModel::truncate();
        CarModel::insert(self::MODELS);
    }
}
