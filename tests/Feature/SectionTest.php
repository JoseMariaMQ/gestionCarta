<?php

namespace Tests\Feature;

use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class SectionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStoreSection()
    {
//        $response = $this->get('/');

//        $response->assertStatus(200);

        $user = User::factory()->create();
        $testStoreSection = [
            'name' => 'My test section',
            'order' => 1
        ];
        $response = $this->actingAs($user, 'api')->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post('api/section', $testStoreSection);

        $response->assertStatus(Response::HTTP_CREATED);

        /*$section = Section::all();
        $this->assertNotNull($section);*/

        $this->get('/api/auth/logout');

        //No login
        $response = $this->post('/api/section', $testStoreSection);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
