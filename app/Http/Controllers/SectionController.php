<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SectionController extends Controller
{
    /**
     * List all sections
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        try {
            //The model's all method will retrieve all of the records from the model's associated database table
            $sections = Section::all();

            if (!empty($sections)) {
                return response()->json([
                    $sections
                ]);
            } else {
                return response()->json([
                    'message' => 'No sections'
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Store new section
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'picture' => 'required|string|max:255',
                'hidden' => 'required|boolean'
            ]);

            Section::create([
                'name' => $request->name,
                'picture' => $request->picture,
                'hidden' => $request->hidden,
            ]);

            return response()->json([
                'message' => 'Successfully created section!'
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
     * Get a section
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request) {
        try {
            // Retrieve single records using the find method
            $section = Section::find($request->id);

            if (isset($section)) {
                return response()->json([
                    $section
                ]);
            } else {
                return response()->json([
                    'message' => 'There is no section with that ID'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update all section's fields
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request) {
        try {
            $section = Section::find($request->id);

            if (!empty($section)) {
                $section->update($request->all());
                return response()->json([
                    'message' => 'Successfully updated section!'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'There is no section with that ID'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Delete a section
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request) {
        try {
            $section = Section::find($request->id);

            if (!empty($section)) {
                $section->delete($request->all());
                return response()->json([
                    'message' => 'Successfully deleted section!'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'There is no section with that ID'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}