<?php

namespace Tests\Unit\Policies;

use App\Forest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTest as TestCase;

class ForestPolicyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_create_forest()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Forest));
    }

    /** @test */
    public function user_can_view_forest()
    {
        $user = $this->createUser();
        $forest = factory(Forest::class)->create();
        $this->assertTrue($user->can('view', $forest));
    }

    /** @test */
    public function user_can_update_forest()
    {
        $user = $this->createUser();
        $forest = factory(Forest::class)->create();
        $this->assertTrue($user->can('update', $forest));
    }

    /** @test */
    public function user_can_delete_forest()
    {
        $user = $this->createUser();
        $forest = factory(Forest::class)->create();
        $this->assertTrue($user->can('delete', $forest));
    }
}
