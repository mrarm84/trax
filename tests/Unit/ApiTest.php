<?php

namespace Tests\Unit;

use App\Car;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Tests\CreatesApplication;
use Tests\TestCase;

class ApiTest extends TestCase
{

    use CreatesApplication, DatabaseMigrations;


    protected $user;
    protected $car;
    protected $carId;

    public function setUp() :void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->car = factory(Car::class, )->make();

        Artisan::call('db:seed');

        $this->seed('DatabaseSeeder');

    }

    public function tearDown():void
    {

        parent::tearDown();
    }


    public function testGetCarsUnauthenticated()
    {
        Auth::logout();

      $this->json('GET', '/api/get-cars', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }



    public function testsTripsWithCarAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();


        $headers = ['Accept' => 'application/json'];
        $payload = ['year' => '2017', 'make' => 'Test', 'model' => 'Test', ];

        $response = $this
            ->actingAs($user, 'api')
            ->json('POST', '/api/add-car', $payload, $headers)
            ->assertStatus(201);

        $json = json_decode($response->getContent());
        $this->assertDatabaseHas('cars', ['id' => $json->data->id]);


        $payload = ['date' => '10-01-2017', 'total' => 1, 'car_id' => $json->data->id, 'miles' => 10 ];

        $response = $this
            ->actingAs($user, 'api')
            ->json('POST', '/api/add-trip', $payload)

            ->assertStatus(201);
        $jsonTrip = json_decode($response->getContent());
        $this->assertDatabaseHas('cars', ['id' => $jsonTrip->data->id]);
    }


    public function test_task_crud_is_working()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->get('/api/get-cars');
        $response->assertOk();

        $response = $this->actingAs($user, 'api')->get('/api/get-trips');
        $response->assertOk();

        $response = $this->actingAs($user, 'api')->post('/api/add-car', ['year' => '2017', 'make' => 'Test', 'model' => 'Test', ],  ['Accept' => 'application/json']);
        $response->assertStatus(201);
        $json = json_decode($response->getContent());
        $carId = $json->data->id;

        $this->assertDatabaseHas('cars', ['id' => $carId]);

        $response = $this->actingAs($user, 'api')->post('/api/add-trip', ['date' => '10-01-2017', 'total' => 1, 'car_id' => $json->data->id, 'miles' => 10 ],  ['Accept' => 'application/json']);
        $response->assertStatus(201);
        $jsonTrip = json_decode($response->getContent());
        $tripId = $jsonTrip->data->id;
        $this->assertDatabaseHas('cars', ['id' => $tripId]);

        $this->json('DELETE', '/api/delete-car/' . $carId, ['Accept' => 'application/json'])
            ->assertStatus(200);
        $this->assertDatabaseMissing('cars', ['id' => $carId]);
    }




    public function test_task_crud_validation_is_working()
    {
        $user = factory(User::class)->create();

         $this->actingAs($user, 'api')->post('/api/add-trip', ['date' => '20-04-2017', 'car_id' => 1, 'miles' => 12, 'total' => null],  ['Accept' => 'application/json'])
            ->assertJsonFragment(
                ['error' => ['total' =>[ 'The total must be a number.']]]
            );

        $this->actingAs($user, 'api')->post('/api/add-trip', ['date' => null, 'car_id' => 1, 'miles' => 12,],  ['Accept' => 'application/json'])
            ->assertJsonFragment(
                ['error' => ['date' =>[ 'The date field is required.']]]
            );

    }


    public function testGetCars()
    {
        $car = factory(Car::class, )->create();

        $carArray = $car->toArray();
        unset($carArray['created_at']);
        unset($carArray['updated_at']);
        $this
            ->actingAs($this->user , 'api')
            ->json('GET', '/api/get-cars', ['Accept' => 'application/json'])
            ->assertOk()
            ->assertStatus(200)
            ->assertJsonFragment(
                $carArray
            );
    }

}
