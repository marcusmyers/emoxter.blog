<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /** @test */
    public function can_see_home_page_profile()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('eMoxter')
            ->assertSee('Mark Myers')
            ->assertSee('the_markmyers');
    }
}
