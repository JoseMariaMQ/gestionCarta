<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DrinkController extends Controller
{

    /**
     * List all drinks
     * @param Request $request
     * @param $parent_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $parent_id) {
        $section = Section::findOrFail($parent_id);
        return $section->drinks->append('picture');
    }

    /**
     * Store new drink
     * @param Request $request
     * @param $parent_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $parent_id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|max:999999.99',
            'hidden' => 'boolean',
        ]);

        $drink = Drink::create([
            'name' => $request->name,
            'price' => $request->price,
            'hidden' => $request->hidden ? $request->hidden : false,
            'section_id' => $parent_id
        ]);

        return $this->successResponse(Response::HTTP_CREATED, $drink);
    }

    /**
     * Get a drink
     * @param Request $request
     * @param $parent_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        return $section->drinks()->findOrFail($id)->append('picture');
    }

    /**
     * Update all drink's fields
     * @param Request $request
     * @param $parent_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        $drink = $section->drinks()->findOrFail($id);
        $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric|max:999999.99',
            'hidden' => 'boolean'
        ]);

        $drink->update($request->all());

        return $this->successResponse(Response::HTTP_OK, $drink);
    }

    /**
     * Delete a drink
     * @param Request $request
     * @param $parent_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        $drink = $section->drinks()->findOrFail($id);

        $drink->delete();

        return $this->successResponse(Response::HTTP_OK);
    }
}
