<?php

namespace App\Http\Controllers;

use App\Models\AllergenDish;
use App\Models\Dish;
use App\Models\Picture;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DishController extends Controller
{
    /**
     * List all dishes
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        try {
            //The model's all method will retrieve all of the records from the model's associated database table
            $dishes = Dish::all();

            if ($dishes->count() > 0) {
                return response()->json([
                    $dishes
                ]);
            } else {
                return response()->json([
                    'message' => 'No dishes'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store new dish
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|max:999999.99',
                'units' => 'integer',
                'extra' => 'boolean',
                'hidden' => 'boolean',
                'menu' => 'boolean',
                'price_menu' => 'numeric|max:999999.99',
                'ingredients' => 'string',
                'picture' => 'image|mimes:jpg,jpeg,png|max:1024',
                'section_id' => 'required|integer|exists:App\Models\Section,id',
                'allergens_id' => 'exists:App\Models\Allergen,id'
            ]);

            if ($validate->fails()) {
                return response()->json([
                   'error' => $validate->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $file = $request->file('picture');
            $path = Storage::putFile('pictures/dishes'. $request->id, $file);
            $url = Storage::url($path);
            $url = url($url);

            $picture = Picture::create([
                'url' => $url
            ]);

            $dish = Dish::create([
                'name' => $request->name,
                'price' => $request->price,
                'units' => $request->units,
                'extra' => $request->extra,
                'hidden' => $request->hidden ? $request->hidden : false, // Check if user enters hidden parameter
                'menu' => $request->menu,
                'price_menu' => $request->price_menu,
                'ingredients' => $request->ingredients,
                'section_id' => $request->section_id,
                'picture_id' => $picture->id
            ]);

            foreach ($request->allergens_id as $allergen_id) {
                AllergenDish::create([
                    'allergen_id' => $allergen_id,
                    'dish_id' => $dish->id
                ]);
            }

            return response()->json([
                'message' => 'Successfully created dish!'
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get a dish
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request) {
        try {
            // Retrieve single records using the find method
            $dish = Dish::find($request->id);
//            $dish = Dish::where('section_id', $request->id)->get();

            if ($dish) {
                return response()->json([
                    $dish
                ]);
            } else {
                return response()->json([
                    'message' => 'There is no dish with that ID'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get a dishes from a section
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showDishesSection(Request $request) {
        try {
            // Retrieve records using the where method
            $dishes = Dish::where('section_id', $request->section_id)->get();

            if ($dishes->count() > 0) {
                return response()->json([
                    $dishes
                ]);
            } else {
                return response()->json([
                    'message' => "There aren't dishes in that section"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update all dish's fields
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request) {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'price' => 'numeric|max:999999.99',
                'units' => 'integer',
                'extra' => 'boolean',
                'hidden' => 'boolean',
                'menu' => 'boolean',
                'price_menu' => 'numeric|max:999999.99',
                'ingredients' => 'string',
                'section_id' => 'integer|exists:App\Models\Section,id',
                'allergens_id' => 'exists:App\Models\Allergen,id'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'error' => $validate->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $dish = Dish::find($request->id);

            if ($dish) {
                $dish->update($request->all());

                foreach ($request->allergens_id as $allergen_id) {
                    AllergenDish::create([
                        'allergen_id' => $allergen_id,
                        'dish_id' => $dish->id
                    ]);
                }

                return response()->json([
                    'message' => 'Successfully updated dish!'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'There is no dish with that ID'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Delete a dish
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request) {
        try {
            $dish = Dish::find($request->id);
            $picture = Picture::find($dish->picture_id);

            if ($dish) {
                // Delete the local image. Modify the url
                Storage::delete(str_replace(url(Storage::url('')), '', $picture->url));

                $dish->delete($request->all());
                $picture->delete($request->all());
                return response()->json([
                    'message' => 'Successfully deleted dish!'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'There is no dish with that ID'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
