<?php

namespace App\Http\Controllers;

use App\Models\DrinkPicture;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DrinkPictureController extends Controller
{
    /**
     * Store a picture with data validation in the data base and using file storage
     * @param Request $request
     * @param $parent_id
     * @param $drink_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $parent_id, $drink_id) {
        /* The findOrFail and firstOrFail methods will retrieve the first result of the query;
        however, if no result is found, an Illuminate\Database\Eloquent\ModelNotFoundException will be thrown */
        $section = Section::findOrFail($parent_id);
        $drink = $section->drinks()->findOrFail($drink_id);
        $request->validate([
            'media' => 'required|image|mimes:jpg,jpeg,png|max:3072'
        ]);

        if ($picture = $drink->drinkPicture) {
            $this->deleteStoragePicture($picture->url);
            $file = $request->file('media');
            $url = url($this->storeStoragePicture($drink_id, $file));

            $picture->update([
                'url' => $url
            ]);
        } else {
            $file = $request->file('media');
            $url = url($this->storeStoragePicture($drink_id, $file));

            DrinkPicture::create([
                'drink_id' => $drink_id,
                'url' => $url
            ]);
        }

        return response()->json([
            'status' => 'Success',
            'data' => null
        ], Response::HTTP_CREATED);
    }

    /**
     * Delete a picture from the database and the file storage
     * @param Request $request
     * @param $parent_id
     * @param $drink_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $parent_id, $drink_id, $id) {
        $section = Section::findOrFail($parent_id);
        $drink = $section->drinks()->findOrFail($drink_id);
        $picture = $drink->drinkPicture()->findOrFail($id);

        $this->deleteStoragePicture($picture->url);

        $picture->delete();

        return response()->json([
            'status' => 'Success',
            'data' => null
        ], Response::HTTP_OK);
    }

    /**
     * Get file path
     * @param $drink_id
     * @return string
     */
    private function getFilePath($drink_id) {
        return 'drink/' . $drink_id . '/pictures';
    }

    /**
     * Delete picture from local storage
     * @param $url
     */
    private function deleteStoragePicture($url) {
        if (Storage::disk('public')->exists(str_replace(url(Storage::disk('public')->url('')), '', $url))) {
            // Delete the local picture. Modify the url
            Storage::disk('public')->delete(str_replace(url(Storage::disk('public')->url('')), '', $url));
        }
    }

    /**
     * Store picture in local storage
     * @param $drink_id
     * @param $file
     * @return string
     */
    private function storeStoragePicture($drink_id, $file) {
        $path = Storage::disk('public')->putFile($this->getFilePath($drink_id), $file); // Automatically generate a unique ID for filename...
        $url = Storage::disk('public')->url($path); // Get the URL for a given file
        return $url;
    }
}
