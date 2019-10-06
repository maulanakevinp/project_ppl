<?php

namespace Tests\Feature\Api;

use App\Forest;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForestListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_retrieve_forest_list()
    {
        $forest = factory(Forest::class)->create();

        $this->getJson(route('api.forests.index'));

        $this->seeJsonSubset([
            'type'     => 'FeatureCollection',
            'features' => [
                [
                    'type'       => 'Feature',
                    'properties' => [
                        'name'       => $forest->name,
                        'address'    => $forest->address,
                        'coordinate' => $forest->coordinate,
                    ],
                    'geometry'   => [
                        'type'        => 'Point',
                        'coordinates' => [
                            $forest->longitude,
                            $forest->latitude,
                        ],
                    ],
                ],
            ],
        ]);
    }
}
