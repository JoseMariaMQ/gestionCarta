<?php

namespace App\Http\Controllers;

use App\Models\AllergenDessert;
use App\Models\Dessert;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DessertController extends Controller
{
    /**
     * List all desserts
     * @param Request $request
     * @param $parent_id
     * @return Dessert[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $parent_id) {
        $section = Section::findOrFail($parent_id);
        return $section->desserts()->with('allergens')->get()->append('picture');
    }

    /**
     * Store new dessert
     * @param Request $request
     * @param $parent_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $parent_id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|max:999999.99',
            'units' => 'filled|integer',
            'extra' => 'filled|boolean',
            'hidden' => 'filled|boolean',
            'menu' => 'filled|boolean',
            'price_menu' => 'filled|numeric|max:999999.99',
            'ingredients' => 'filled|string',
            'allergens_id' => 'filled|exists:App\Models\Allergen,id'
        ]);

        $dessert = Dessert::create([
            'name' => $request->name,
            'price' => $request->price,
            'units' => $request->units,
            'extra' => $request->extra,
            'hidden' => $request->hidden,
            'menu' => $request->menu,
            'price_menu' => $request->price_menu,
            'ingredients' => $request->ingredients,
            'section_id' => $parent_id
        ]);

        if ($request->allergens_id) {
            foreach ($request->allergens_id as $allergen_id) {
                AllergenDessert::create([
                    'allergen_id' => $allergen_id,
                    'dessert_id' => $dessert->id
                ]);
            }
        }

        return $this->successResponse(Response::HTTP_CREATED, $dessert);
    }

    /**
     * Get a dessert
     * @param Request $request
     * @param $parent_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        return $section->desserts()->with('allergens')->findOrFail($id)->append('picture');
    }

    /**
     * Update all dessert's fields
     * @param Request $request
     * @param $parent_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        $dessert = $section->desserts()->findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric|max:999999.99',
            'units' => 'integer',
            'extra' => 'boolean',
            'hidden' => 'boolean',
            'menu' => 'boolean',
            'price_menu' => 'numeric|max:999999.99',
            'ingredients' => 'string',
            'allergens_id' => 'exists:App\Models\Allergen,id'
        ]);

        $dessert->update($request->all());

        if ($request->allergens_id) {
            $allergens = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
            foreach ($request->allergens_id as $allergen_id) {
                $allergenDessert = AllergenDessert::where('allergen_id', $allergen_id)->where('dessert_id', $id)->first();
                $allergens = array_diff($allergens, array($allergen_id));
                if (!$allergenDessert) {
                    AllergenDessert::create([
                        'allergen_id' => $allergen_id,
                        'dessert_id' => $dessert->id
                    ]);
                }
            }
            foreach ($allergens as $allergen) {
                $allergenDessert = AllergenDessert::where('allergen_id', $allergen)->where('dessert_id', $id)->first();
                if ($allergenDessert) {
                    $allergenDessert->delete();
                }
            }
        }

        return $this->successResponse(Response::HTTP_OK, $dessert);
    }

    /**
     * Delete a dessert
     * @param Request $request
     * @param $parent_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        $dessert = $section->desserts()->findOrFail($id);
        $dessert->delete();
        return $this->successResponse(Response::HTTP_OK);
    }
}
