<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SectionController extends Controller
{
    /**
     * List all sections
     *
     * @param Request $request
     * @return Section[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
            // The model's all method will retrieve all of the records from the model's associated database table
            return Section::all()->append('picture');
    }

    /**
     * Store new section
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
            $request->validate([
                'name' => 'required|string|max:255',
                'order' => 'integer',
                'hidden' => 'boolean'
            ]);

            /*$file = $request->file('picture');
            $path = Storage::putFile('pictures/sections', $file);
            $url = Storage::url($path);
            $url = url($url);

            $picture = SectionPicture::create([
                'url' => $url
            ]);*/

            Section::create($request->all());

            return response()->json([
                'status' => 'Success',
                'data' => null
            ], Response::HTTP_CREATED);
    }

    /**
     * Get a section
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id) {
            // Retrieve single records using the findOrFail method
            return Section::findOrFail($id)->append('picture');
    }

    /**
     * Update all section's fields
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
            $section = Section::findOrFail($id);

            $request->validate([
                'name' => 'filled|string|max:255',
                'order' => 'filled|integer',
                'hidden' => 'filled|boolean'
            ]);

            $section->update($request->all());

            return response()->json([
                'status' => 'Success',
                'data' => null
            ], Response::HTTP_OK);
    }

    /**
     * Delete a section
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $id) {
            $section = Section::findOrFail($id);

            $section->delete();

            return response()->json([
                'status' => 'Success',
                'data' => null
            ], Response::HTTP_OK);
    }
}
