<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function blog_route_exist()
    {
        factory(Post::class, 10)->state('published')->create([]);

        $response = $this->get('/blog');

        $response->assertStatus(200)
            ->assertViewHas('posts');
    }
}
