<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\Picture;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DrinkController extends Controller
{

    /**
     * List all drinks
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        try {
            //The model's all method will retrieve all of the records from the model's associated database table
            $drinks = Drink::all();

            if ($drinks->count() > 0) {
                return response()->json([
                    $drinks
                ]);
            } else {
                return response()->json([
                    'message' => 'No drinks'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store new drink
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|max:999999.99',
                'hidden' => 'boolean',
                'picture' => 'image|mimes:jpg,jpeg,png|max:1024',
                'section_id' => 'required|integer|exists:App\Models\Section,id'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'error' => $validate->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $file = $request->file('picture');
            $path = Storage::putFile('pictures/drinks', $file);
            $url = Storage::url($path);
            $url = url($url);

            $picture = Picture::create([
                'url' => $url
            ]);

            Drink::create([
                'name' => $request->name,
                'price' => $request->price,
                'hidden' => $request->hidden ? $request->hidden : false, // Check if user enters hidden parameter
                'section_id' => $request->section_id,
                'picture_id' => $picture->id
            ]);

            return response()->json([
                'message' => 'Successfully created drink!'
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
     * Get a drink
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request) {
        try {
            // Retrieve single records using the find method
            $drink = Drink::find($request->id);

            if ($drink) {
                return response()->json([
                    $drink
                ]);
            } else {
                return response()->json([
                    'message' => 'There is no drink with that ID'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get a drinks from a section
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showDrinksSection(Request $request) {
        try {
            // Retrieve records using the where method
            $drinks = Drink::where('section_id', $request->section_id)->get();

            if ($drinks->count() > 0) {
                return response()->json([
                    $drinks
                ]);
            } else {
                return response()->json([
                    'message' => "There aren't drinks in that section"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update all drink's fields
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request) {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'price' => 'numeric|max:999999.99',
                'hidden' => 'boolean',
                'section_id' => 'integer|exists:App\Models\Section,id'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'error' => $validate->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $drink = Drink::find($request->id);

            if ($drink) {
                $drink->update($request->all());

                return response()->json([
                    'message' => 'Successfully updated drink!'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'There is no drink with that ID'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Delete a drink
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request) {
        try {
            $drink = Drink::find($request->id);
            $picture = Picture::find($drink->picture_id);

            if ($drink) {
                // Delete the local image. Modify the url
                Storage::delete(str_replace(url(Storage::url('')), '', $picture->url));

                $drink->delete($request->all());
                $picture->delete($request->all());
                return response()->json([
                    'message' => 'Successfully deleted drink!'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'There is no drink with that ID'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
