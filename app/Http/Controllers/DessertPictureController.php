<?php

namespace App\Http\Controllers;

use App\Models\DessertPicture;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DessertPictureController extends Controller
{
    /**
     * Store a picture with data validation in the data base and using file storage
     * @param Request $request
     * @param $parent_id
     * @param $dessert_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $parent_id, $dessert_id) {
        /* The findOrFail and firstOrFail methods will retrieve the first result of the query;
        however, if no result is found, an Illuminate\Database\Eloquent\ModelNotFoundException will be thrown */
        $section = Section::findOrFail($parent_id);
        $dessert = $section->desserts()->findOrFail($dessert_id);
        $request->validate([
            'media' => 'required|image|mimes:jpg,jpeg,png|max:3072'
        ]);

        if ($picture = $dessert->dessertPicture) {
            $this->deleteStoragePicture($picture->url);
            $file = $request->file('media');
            $url = url($this->storeStoragePicture($dessert_id, $file));

            $picture->update([
                'url' => $url
            ]);
        } else {
            $file = $request->file('media');
            $url = url($this->storeStoragePicture($dessert_id, $file));

            DessertPicture::create([
                'dessert_id' => $dessert_id,
                'url' => $url
            ]);
        }

        return $this->successResponse(Response::HTTP_CREATED);
    }

    /**
     * Delete a picture from the database and the file storage
     * @param Request $request
     * @param $parent_id
     * @param $dessert_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $parent_id, $dessert_id, $id) {
        $section = Section::findOrFail($parent_id);
        $dessert = $section->desserts()->findOrFail($dessert_id);
        $picture = $dessert->dessertPicture()->findOrFail($id);

        $this->deleteStoragePicture($picture->url);

        $picture->delete();

        return $this->successResponse(Response::HTTP_OK);
    }

    /**
     * Get file path
     *
     * @param $dessert_id
     * @return string
     */
    private function getFilePath($dessert_id) {
        return 'dessert/' . $dessert_id . '/pictures';
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
     * @param $dessert_id
     * @param $file
     * @return string
     */
    private function storeStoragePicture($dessert_id, $file) {
        $path = Storage::disk('public')->putFile($this->getFilePath($dessert_id), $file); // Automatically generate a unique ID for filename...
        $url = Storage::disk('public')->url($path); // Get the URL for a given file
        return $url;
    }
}
