<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetVehiclesTest extends TestCase
{
    /**
     * @test
     */
    public function it_checks_if_the_welcome_page_can_be_opened()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function it_displays_a_list_of_vehicles_for_a_specific_model_year_manufacturer_and_model()
    {
        $response = $this->json('GET', '/vehicles/2015/Audi/A3');

        $response->assertStatus(200);
        $response->assertExactJson([
            "Count" => 4,
            "Results" => [
                [
                    "Description" => "2015 Audi A3 4 DR AWD",
                    "VehicleId" => 9403
                ],
                [
                    "Description" => "2015 Audi A3 4 DR FWD",
                    "VehicleId" => 9408
                ],
                [
                    "Description" => "2015 Audi A3 C AWD",
                    "VehicleId" => 9405
                ],
                [
                    "Description" => "2015 Audi A3 C FWD",
                    "VehicleId" => 9406
                ],
            ]
        ]);

        $response = $this->json('GET', '/vehicles/2015/Toyota/Yaris');

        $response->assertStatus(200);
        $response->assertExactJson([
            "Count" => 2,
            "Results" => [
                [
                    "Description" => "2015 Toyota Yaris 3 HB FWD",
                    "VehicleId" => 9791
                ],
                [
                    "Description" => "2015 Toyota Yaris Liftback 5 HB FWD",
                    "VehicleId" => 9146
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function it_displays_an_empty_result_set_when_there_are_no_vehicles_for_the_specific_model_year_manufacturer_and_model(
    )
    {
        $response = $this->json('GET', '/vehicles/2015/Ford/Crown Victoria');

        $response->assertStatus(200);
        $response->assertExactJson([
            "Count" => 0,
            "Results" => []
        ]);
    }

    /**
     * @test
     */
    public function it_displays_an_empty_result_set_when_the_model_year_is_invalid()
    {
        $response = $this->json('GET', '/vehicles/undefined/Ford/Fusion');

        $response->assertStatus(200);
        $response->assertExactJson([
            "Count" => 0,
            "Results" => []
        ]);
    }

    /**
     * @test
     */
    public function it_displays_a_list_of_vehicles_for_a_specific_model_year_manufacturer_and_model_when_using_a_post_request()
    {
        $response = $this->json('POST', '/vehicles', [
            "modelYear" => 2015,
            "manufacturer" => "Audi",
            "model" => "A3"
        ]);

        $response->assertStatus(200);
        $response->assertExactJson([
            "Count" => 4,
            "Results" => [
                [
                    "Description" => "2015 Audi A3 4 DR AWD",
                    "VehicleId" => 9403
                ],
                [
                    "Description" => "2015 Audi A3 4 DR FWD",
                    "VehicleId" => 9408
                ],
                [
                    "Description" => "2015 Audi A3 C AWD",
                    "VehicleId" => 9405
                ],
                [
                    "Description" => "2015 Audi A3 C FWD",
                    "VehicleId" => 9406
                ],
            ]
        ]);

        $response = $this->json('POST', '/vehicles', [
            "modelYear" => 2015,
            "manufacturer" => "Toyota",
            "model" => "Yaris"
        ]);

        $response->assertStatus(200);
        $response->assertExactJson([
            "Count" => 2,
            "Results" => [
                [
                    "Description" => "2015 Toyota Yaris 3 HB FWD",
                    "VehicleId" => 9791
                ],
                [
                    "Description" => "2015 Toyota Yaris Liftback 5 HB FWD",
                    "VehicleId" => 9146
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function it_displays_an_empty_result_set_when_the_post_request_body_is_invalid()
    {
        $response = $this->json('POST', '/vehicles', [
            "manufacturer" => "Honda",
            "model" => "Accord"
        ]);

        $response->assertStatus(200);
        $response->assertExactJson([
            "Count" => 0,
            "Results" => []
        ]);
    }

    /**
     * @test
     */
    public function it_displays_a_list_of_vehicles_with_crash_rating_for_a_specific_model_year_manufacturer_and_model_when_the_with_rating_flag_is_equal_to_true()
    {
        $response = $this->json('GET', '/vehicles/2015/Audi/A3?withRating=true');

        $response->assertStatus(200);
        $response->assertExactJson([
            "Count" => 4,
            "Results" => [
                [
                    "Description" => "2015 Audi A3 4 DR AWD",
                    "VehicleId" => 9403,
                    "CrashRating" => "5"
                ],
                [
                    "Description" => "2015 Audi A3 4 DR FWD",
                    "VehicleId" => 9408,
                    "CrashRating" => "5"
                ],
                [
                    "Description" => "2015 Audi A3 C AWD",
                    "VehicleId" => 9405,
                    "CrashRating" => "Not Rated"
                ],
                [
                    "Description" => "2015 Audi A3 C FWD",
                    "VehicleId" => 9406,
                    "CrashRating" => "Not Rated"
                ],
            ]
        ]);
    }

    /**
     * @test
     */
    public function it_displays_a_list_of_vehicles_without_crash_rating_for_a_specific_model_year_manufacturer_and_model_when_the_with_rating_flag_is_equal_to_false()
    {
        $response = $this->json('GET', '/vehicles/2015/Audi/A3?withRating=false');

        $response->assertStatus(200);
        $response->assertExactJson([
            "Count" => 4,
            "Results" => [
                [
                    "Description" => "2015 Audi A3 4 DR AWD",
                    "VehicleId" => 9403,
                ],
                [
                    "Description" => "2015 Audi A3 4 DR FWD",
                    "VehicleId" => 9408,
                ],
                [
                    "Description" => "2015 Audi A3 C AWD",
                    "VehicleId" => 9405,
                ],
                [
                    "Description" => "2015 Audi A3 C FWD",
                    "VehicleId" => 9406,
                ],
            ]
        ]);
    }

    /**
     * @test
     */
    public function it_displays_a_list_of_vehicles_without_crash_rating_for_a_specific_model_year_manufacturer_and_model_when_the_with_rating_flag_is_not_equal_to_true_or_false()
    {
        $response = $this->json('GET', '/vehicles/2015/Audi/A3?withRating=banana');

        $response->assertStatus(200);
        $response->assertExactJson([
            "Count" => 4,
            "Results" => [
                [
                    "Description" => "2015 Audi A3 4 DR AWD",
                    "VehicleId" => 9403,
                ],
                [
                    "Description" => "2015 Audi A3 4 DR FWD",
                    "VehicleId" => 9408,
                ],
                [
                    "Description" => "2015 Audi A3 C AWD",
                    "VehicleId" => 9405,
                ],
                [
                    "Description" => "2015 Audi A3 C FWD",
                    "VehicleId" => 9406,
                ],
            ]
        ]);
    }
}
