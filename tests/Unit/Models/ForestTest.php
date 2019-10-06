<?php

namespace Tests\Unit\Models;

use App\User;
use App\Forest;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ForestTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_forest_has_name_link_attribute()
    {
        $forest = factory(Forest::class)->create();

        $title = __('app.show_detail_title', [
            'name' => $forest->name, 'type' => __('forest.forest'),
        ]);
        $link = '<a href="' . route('forests.show', $forest) . '"';
        $link .= ' title="' . $title . '">';
        $link .= $forest->name;
        $link .= '</a>';

        $this->assertEquals($link, $forest->name_link);
    }

    /** @test */
    public function an_forest_has_belongs_to_creator_relation()
    {
        $forest = factory(Forest::class)->make();

        $this->assertInstanceOf(User::class, $forest->creator);
        $this->assertEquals($forest->creator_id, $forest->creator->id);
    }

    /** @test */
    public function an_forest_has_coordinate_attribute()
    {
        $forest = factory(Forest::class)->make(['latitude' => '-3.333333', 'longitude' => '114.583333']);
        $this->assertEquals($forest->latitude . ', ' . $forest->longitude, $forest->coordinate);

        $forest = factory(Forest::class)->make(['latitude' => null, 'longitude' => null]);
        $this->assertNull($forest->coordinate);

        $forest = factory(Forest::class)->make(['latitude' => null, 'longitude' => '114.583333']);
        $this->assertNull($forest->coordinate);
    }

    /** @test */
    public function an_forest_has_map_popup_content_attribute()
    {
        $forest = factory(Forest::class)->make(['lat' => '-3.333333', 'long' => '114.583333']);

        $mapPopupContent = '';
        $mapPopupContent .= '<div class="my-2"><strong>' . __('forest.name') . ':</strong><br>' . $forest->name_link . '</div>';
        $mapPopupContent .= '<div class="my-2"><strong>' . __('forest.coordinate') . ':</strong><br>' . $forest->coordinate . '</div>';

        $this->assertEquals($mapPopupContent, $forest->map_popup_content);
    }
}
