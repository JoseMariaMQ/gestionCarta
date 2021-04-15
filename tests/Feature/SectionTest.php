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

    /**
     * Test to verify that an object returns
     */
    public function testListSections() {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->get(route('section'));
        $response->assertOk();
    }

    /**
     * Test to verify that you are unauthenticated
     */
    public function testSectionUnauthenticated() {
        $response = $this->get(route('section'));
        $response->assertJson([
            'status' => 'error',
            'data' => 'Unauthenticated.'
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
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
     * Test that verifies the failure in the validation of the input data in store
     * @dataProvider requiredStoreValidationProvider
     */
    public function testStoreSectionFail($key, $value) {
        $user = User::factory()->create();
        $section = Section::factory()->create()->toArray();
        unset($section['updated_at'], $section['created_at'], $section['id']);

        $response = $this->actingAs($user, 'api')->post(route('section.store'),
            array_replace($section, [$key => $value]));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test that checks the method that shows a section by its id
     */
    public function testShowSection() {
        $user = User::factory()->create();
        $section = Section::factory()->create();

        $response = $this->actingAs($user, 'api')->get(route('section.show', ['id' => $section->id]));
        $response->assertJsonStructure([
            "id",
            "name",
            "order",
            "hidden",
            "updated_at",
            "created_at"
        ])->assertOk();
    }

    /**
     * Test that checks the method that fails when a section does not exist by its id.
     */
    public function testShowSectionFail() {
        $user = User::factory()->create();
        $id = 1;
        $response = $this->actingAs($user, 'api')->get(route('section.show', ['id' => $id]));
        $response->assertJson([
            "status" => "fail",
            "data" => "No query results for model [App\\Models\\Section] $id"
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     *
     */
    public function testUpdateSectionSuccess() {
        $user = User::factory()->create();
        $section = Section::factory()->create();

        $response = $this->actingAs($user, 'api')->put(route('section.update', ['id' => $section->id]), [
            'name' => Str::random(45),
            'order' => rand(1, 100),
            'hidden' => rand(0, 1)
        ]);

        $response->assertJson([
            'status' => 'Success',
            'data' => null
        ])->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test that verifies the failure in the validation of the input data in update
     * @dataProvider requiredStoreValidationProvider
     */
    public function testUpdateSectionFail($key, $value) {
        $user = User::factory()->create();
        $section = Section::factory()->create();
        $sectionArray = $section->toArray();
        unset($sectionArray['updated_at'], $sectionArray['created_at'], $sectionArray['id']);

        $this->actingAs($user, 'api')->put(route('section.update', ['id' => $section->id]),
            array_replace($sectionArray, [$key => $value]))->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $id = 20;
        $this->actingAs($user, 'api')->put(route('section.update', ['id' => $id]), [
            'name' => Str::random(45),
            'order' => rand(1, 100),
            'hidden' => rand(0, 1)
        ])->assertJson([
            "status" => "fail",
            "data" => "No query results for model [App\\Models\\Section] $id"
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Test of the method that succeeds when a section is deleted by id.
     */
    public function testDeleteSectionSuccess() {
        $user = User::factory()->create();
        $section = Section::factory()->create();

        $this->actingAs($user, 'api')->delete(route('section.delete', ['id' => $section->id]))
            ->assertJson([
                'status' => 'Success',
                'data' => null
            ])->assertOk();
    }

    /**
     * Test that checks the method that fails when a section does not exist by its id in delete.
     */
    public function testDeleteSectionFail() {
        $user = User::factory()->create();
        $id = 1;
        $this->actingAs($user, 'api')->delete(route('section.delete', ['id' => $id]))
            ->assertJson([
                "status" => "fail",
                "data" => "No query results for model [App\\Models\\Section] $id"
            ])->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Required store data validation provider.
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
            ['order', 100000000e10000000],
            ['hidden', ''],
            ['hidden', 123],
            ['hidden', 'abc'],
            ['hidden', null],
        ];
    }
}
