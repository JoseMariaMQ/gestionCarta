<?php

namespace Tests\Feature;

use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class SectionTest extends TestCase
{
    use RefreshDatabase;

    private $fields = [
        'name' => 'chema@gmail.com',
        'order' => 1,
        'hidden' => false
    ];

    /**
     *
     */
    public function testListSections() {
        $user = User::factory()->create();
        $sections = Section::factory(10)->create();

        $response = $this->actingAs($user, 'api')->get(route('section'));
        $response->assertOk();
    }

    /**
     *
     */
    public function testSectionUnauthenticated() {
        /*$routes = [
            route('section'),
            route('section.store'),
            route('section.show'),
            route('section.update'),
            route('section.delete'),
        ];*/
//        foreach ($routes as $route) {
            $response = $this->get(route('section'));
            $response->assertJson([
                'status' => 'error',
                'data' => 'Unauthenticated.'
            ])->assertStatus(Response::HTTP_BAD_REQUEST);
//        }
    }

    /**
     * Test that verifies the success of the storage in the database.
     * @return void
     */
    public function testStoreSectionSuccess()
    {
        $user = User::factory()->create();
        $section = Section::factory()->create();

        $response = $this->actingAs($user, 'api')->post(route('section.store'), [
            'name' => $section->name,
            'order' => $section->order,
            'hidden' => $section->hidden
        ]);

        $response->assertJson([
            'status' => 'Success',
            'data' => null
        ])->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Test that verifies the failure in the validation of the input data
     * @dataProvider requiredStoreValidationProvider
     */
    public function testStoreSectionFail($input, $value) {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->post(route('section.store'), [
            array_replace($this->fields, [$input => $value])
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Required store data validation provider.
     *
     * @return \string[][]
     */
    public function requiredStoreValidationProvider()
    {
        return [
            ['name', ''],
            ['name', Str::random(256)],
            ['name', true],
            ['name', null],
            ['order', 'abc'],
            ['order', 2.5],
            ['order', false],
            ['hidden', ''],
            ['hidden', 123],
            ['hidden', 'abc'],
        ];
    }
}
