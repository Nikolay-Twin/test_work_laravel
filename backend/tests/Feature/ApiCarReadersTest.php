<?php
declare(strict_types=1);
namespace Tests\Feature;

use Database\Seeders\CarMarkSeeder;
use Database\Seeders\CarModelSeeder;
use Database\Seeders\CarSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApiCarReadersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    protected function seedData(): void
    {
        $this->seed(CarMarkSeeder::class);
        $this->seed(CarModelSeeder::class);
        $this->seed(CarSeeder::class);
    }

    /**
     * Empty car marks.
     */
    public function test_car_mark_read_error()
    {
        $response = $this->getJson('/api/v1/mark');

        $this->assertEquals(404, $response->status());
        $response->assertJson(static function(AssertableJson $json) {
            $json->has('message')
                 ->missing('success')
                 ->etc();
        });
    }

    /**
     * Read all car marks.
     */
    public function test_car_mark_read_success()
    {
        $this->seedData();
        $response = $this->getJson('/api/v1/mark');

        $this->assertEquals(200, $response->status());
        $response->assertJson(static function(AssertableJson $json) {
            $json->has('success')
                 ->where('data', CarMarkSeeder::MARKS)
                 ->where('message', [])
                 ->etc();
        });
    }

    /**
     * Car models bad request
     */
    public function test_car_model_read_error()
    {
        $response = $this->getJson('/api/v1/model/bar');

        $this->assertEquals(422, $response->status());
        $response->assertJson(static function(AssertableJson $json) {
            $json->has('message')
                 ->has('errors')
                 ->missing('success')
                 ->etc();
        });
    }

    /**
     * Car models not found.
     */
    public function test_car_model_read_empty()
    {
        $this->seedData();
        $response = $this->getJson('/api/v1/model/00000000-0000-0000-0000-000000000000');

        $this->assertEquals(404, $response->status());
        $response->assertJson(static function(AssertableJson $json) {
            $json->has('message')
                 ->where('errors' , [])
                 ->missing('success')
                 ->etc();
        });
    }

    /**
     * Read all car models.
     */
    public function test_car_model_read_success()
    {
        $this->seedData();
        $response = $this->getJson('/api/v1/model/954b60a4-13ee-4fb6-9e4a-044bd251fe88');

        $this->assertEquals(200, $response->status());
        $data = CarModelSeeder::MODELS;
        $response->assertJson(static function(AssertableJson $json) use($data) {
            $json->has('success')
                ->where('data', [$data[0], $data[1], $data[2]])
                ->where('message', [])
                ->etc();
        });
    }

    /**
     * Read all car models.
     */
    public function test_car_all_model_read_success()
    {
        $this->seedData();
        $response = $this->getJson('/api/v1/model');

        $this->assertEquals(200, $response->status());
        $response->assertJson(static function(AssertableJson $json) {
            $json->has('success')
                ->where('data', CarModelSeeder::MODELS)
                ->where('message', [])
                ->etc();
        });
    }

    /**
     * Read all cars.
     */
    public function test_car_all_read_success()
    {
        $this->seedData();
        $response = $this->getJson('/api/v1/car');

        $this->assertEquals(200, $response->status());

        $data = CarSeeder::CARS;
        array_walk($data, static function (&$item, $key) {
            if (0 === $key) {
                $item['markName'] = 'Mercedes-Benz';
                $item['modelName'] = 'C-Class';
            } else {
                $item['markName'] = 'Renault';
                $item['modelName'] = 'LOGAN';
            }
        });

        $response->assertJson(static function(AssertableJson $json) use ($data) {
            $json->has('success')
                ->where('data', $data)
                ->where('message', [])
                ->etc();
        });
    }

    /**
     * Read one car.
     */
    public function test_car_read_success()
    {
        $this->seedData();
        $response = $this->getJson('/api/v1/car/784a603d-25fc-b64f-4a9e-28ce5331ac12');

        $this->assertEquals(200, $response->status());

        $data = CarSeeder::CARS[0];
        $data['markName'] = 'Mercedes-Benz';
        $data['modelName'] = 'C-Class';

        $response->assertJson(static function(AssertableJson $json) use ($data) {
            $json->has('success')
                ->where('data', [$data])
                ->where('message', [])
                ->etc();
        });
    }
}
