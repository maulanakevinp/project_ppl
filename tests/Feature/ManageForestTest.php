<?php

namespace Tests\Feature;

use App\Forest;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManageForestTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_forest_list_in_forest_index_page()
    {
        $forest = factory(Forest::class)->create();

        $this->loginAsUser();
        $this->visitRoute('forests.index');
        $this->see($forest->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'      => 'Forest 1 name',
            'address'   => 'Forest 1 address',
            'latitude'  => '-3.333333',
            'longitude' => '114.583333',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_forest()
    {
        $this->loginAsUser();
        $this->visitRoute('forests.index');

        $this->click(__('forest.create'));
        $this->seeRouteIs('forests.create');

        $this->submitForm(__('forest.create'), $this->getCreateFields());

        $this->seeRouteIs('forests.show', Forest::first());

        $this->seeInDatabase('forests', $this->getCreateFields());
    }

    /** @test */
    public function validate_forest_name_is_required()
    {
        $this->loginAsUser();

        // name empty
        $this->post(route('forests.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_forest_name_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // name 70 characters
        $this->post(route('forests.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_forest_address_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // address 256 characters
        $this->post(route('forests.store'), $this->getCreateFields([
            'address' => str_repeat('Long forest address', 16),
        ]));
        $this->assertSessionHasErrors('address');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'      => 'Forest 1 name',
            'address'   => 'Forest 1 address',
            'latitude'  => '-3.333333',
            'longitude' => '114.583333',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_forest()
    {
        $this->loginAsUser();
        $forest = factory(Forest::class)->create(['name' => 'Testing 123']);

        $this->visitRoute('forests.show', $forest);
        $this->click('edit-forest-' . $forest->id);
        $this->seeRouteIs('forests.edit', $forest);

        $this->submitForm(__('forest.update'), $this->getEditFields());

        $this->seeRouteIs('forests.show', $forest);

        $this->seeInDatabase('forests', $this->getEditFields([
            'id' => $forest->id,
        ]));
    }

    /** @test */
    public function validate_forest_name_update_is_required()
    {
        $this->loginAsUser();
        $forest = factory(Forest::class)->create(['name' => 'Testing 123']);

        // name empty
        $this->patch(route('forests.update', $forest), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_forest_name_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $forest = factory(Forest::class)->create(['name' => 'Testing 123']);

        // name 70 characters
        $this->patch(route('forests.update', $forest), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_forest_address_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $forest = factory(Forest::class)->create(['name' => 'Testing 123']);

        // address 256 characters
        $this->patch(route('forests.update', $forest), $this->getEditFields([
            'address' => str_repeat('Long forest address', 16),
        ]));
        $this->assertSessionHasErrors('address');
    }

    /** @test */
    public function user_can_delete_a_forest()
    {
        $this->loginAsUser();
        $forest = factory(Forest::class)->create();
        factory(Forest::class)->create();

        $this->visitRoute('forests.edit', $forest);
        $this->click('del-forest-' . $forest->id);
        $this->seeRouteIs('forests.edit', [$forest, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('forests', [
            'id' => $forest->id,
        ]);
    }
}
