<?php
declare(strict_types=1);
namespace Feature;

use Database\Seeders\CarMarkSeeder;
use Database\Seeders\CarModelSeeder;
use Database\Seeders\CarSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApiCarCrudTest extends TestCase
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
     * Create car.
     */
    public function test_car_create()
    {
        $this->seedData();
        $data = [
            'name' => 'Ласточка',
            'model_id' => '6d6eb849-bf93-4468-9d85-d5ca79b91648',
            'year' => '2011',
            'mileage' => '100000',
            'color' => 'серо-буро-малиновый'
        ];
        $response = $this->postJson('/api/v1/car', $data, [
            'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type'     => 'application/json'
        ]);

        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('data.0.name', 'Ласточка');
        $response->assertJson(static function(AssertableJson $json) {
            $json->has('success')
                 ->where('message', [])
                 ->etc();
        });
    }

    /**
     * Update car (скрутим пробег :) )
     */
    public function test_car_update()
    {
        $this->seedData();
        $data = [
            "car_id" => "5419db1e-657a-4847-c23f-a154321b0a27",
            "year" => "2023",
            "mileage" => "100",
        ];

        $response = $this->putJson('/api/v1/car', $data, [
            'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type'     => 'application/json'
        ]);

        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('message.changes.year', '2023');
        $response->assertJsonPath('message.changes.mileage', '100');
        $response->assertJson(static function(AssertableJson $json) {
            $json->has('success')
                 ->etc();
        });
    }

    /**
     * Delete car
     */
    public function test_car_delete()
    {
        $this->seedData();
        $data = [
            "delete" => [
                "784a603d-25fc-b64f-4a9e-28ce5331ac12",
                "00000000-0000-0000-0000-000000000000"
            ],
        ];
        $response = $this->deleteJson('/api/v1/car', $data, [
            'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type'     => 'application/json'
        ]);

        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('data.deleted.0', '784a603d-25fc-b64f-4a9e-28ce5331ac12');
        $response->assertJsonPath('message.errors.0.id', '00000000-0000-0000-0000-000000000000');
        $response->assertJson(static function(AssertableJson $json) {
            $json->has('success')
                 ->etc();
        });
    }
}
