<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\Section;
use App\Models\SectionPicture;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DrinkController extends Controller
{

    /**
     * List all drinks
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $parent_id) {
        $section = Section::findOrFail($parent_id);
        return $section->drinks->append('picture');
    }

    /**
     * Store new drink
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $parent_id) {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|max:999999.99',
                'hidden' => 'boolean',
            ]);

            /*$file = $request->file('picture');
            $path = Storage::putFile('pictures/drinks', $file);
            $url = Storage::url($path);
            $url = url($url);

            $picture = SectionPicture::create([
                'url' => $url
            ]);*/

            Drink::create([
                'name' => $request->name,
                'price' => $request->price,
                'hidden' => $request->hidden ? $request->hidden : false,
                'section_id' => $parent_id
            ]);

            return response()->json([
                'status' => 'Success',
                'data' => null
            ], Response::HTTP_CREATED);
    }

    /**
     * Get a drink
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        return $section->drinks()->findOrFail($id)->append('picture');
    }

    /**
     * Update all drink's fields
     *
     * @param Request $request
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

        return response()->json([
            'status' => 'Success',
            'data' => null
        ], Response::HTTP_OK);
    }

    /**
     * Delete a drink
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        $drink = $section->drinks()->findOrFail($id);

        $drink->delete();

        return response()->json([
            'status' => 'Success',
            'data' => null
        ], Response::HTTP_OK);
    }
}
