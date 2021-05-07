<?php

namespace App\Http\Controllers;

use App\Models\AllergenDish;
use App\Models\Dish;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DishController extends Controller
{
    /**
     * List all dishes
     * @param Request $request
     * @param $parent_id
     * @return Dish[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $parent_id) {
        $section = Section::findOrFail($parent_id);
        return $section->dishes()->with('allergens')->get()->append('picture');
    }

    /**
     * Store new dish
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

        $dish = Dish::create([
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
                AllergenDish::create([
                    'allergen_id' => $allergen_id,
                    'dish_id' => $dish->id
                ]);
            }
        }

        return $this->successResponse(Response::HTTP_CREATED, $dish);
    }

    /**
     * Get a dish
     * @param Request $request
     * @param $parent_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        return $section->dishes()->with('allergens')->findOrFail($id)->append('picture');
    }

    /**
     * Update all dish's fields
     * @param Request $request
     * @param $parent_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        $dish = $section->dishes()->findOrFail($id);

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

        $dish->update($request->all());

        if ($request->allergens_id) {
            $allergens = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
            foreach ($request->allergens_id as $allergen_id) {
                $allergenDish = AllergenDish::where('allergen_id', $allergen_id)->where('dish_id', $id)->first();
                $allergens = array_diff($allergens, array($allergen_id));
                if (!$allergenDish) {
                    AllergenDish::create([
                        'allergen_id' => $allergen_id,
                        'dish_id' => $dish->id
                    ]);
                }
            }
            foreach ($allergens as $allergen) {
                $allergenDish = AllergenDish::where('allergen_id', $allergen)->where('dish_id', $id)->first();
                if ($allergenDish) {
                    $allergenDish->delete();
                }
            }
        }

        return $this->successResponse(Response::HTTP_OK, $dish);
    }

    /**
     * Delete a dish
     * @param Request $request
     * @param $parent_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        $dish = $section->dishes()->findOrFail($id);
        $dish->delete();
        return $this->successResponse(Response::HTTP_OK);
    }
}
