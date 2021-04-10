<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\SectionPicture;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class SectionPictureController extends Controller
{
    /**
     * Store a picture with data validation in the data base and using file storage
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $parent_id) {
        /* The findOrFail and firstOrFail methods will retrieve the first result of the query;
        however, if no result is found, an Illuminate\Database\Eloquent\ModelNotFoundException will be thrown */
        $section = Section::findOrFail($parent_id);

        $request->validate([
            'media' => 'required|image|mimes:jpg,jpeg,png|max:3072'
        ]);

        if ($picture = $section->sectionPicture) {
            $this->deleteStoragePicture($picture->url);
            $file = $request->file('media');
            $url = url($this->storeStoragePicture($parent_id, $file));

            $picture->update([
                'url' => $url
            ]);
        } else {
            $file = $request->file('media');
            $url = url($this->storeStoragePicture($parent_id, $file));

            SectionPicture::create([
                'section_id' => $parent_id,
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
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $parent_id, $id) {
        $section = Section::findOrFail($parent_id);
        $picture = $section->sectionPicture()->findOrFail($id);

        $this->deleteStoragePicture($picture->url);

        $picture->delete();

        return response()->json([
            'status' => 'Success',
            'data' => null
        ], Response::HTTP_OK);
    }

    /**
     * Get file path
     *
     * @param $section_id
     * @return string
     */
    private function getFilePath($section_id) {
        return 'section/' . $section_id . '/pictures';
    }

    /**
     * Delete picture from local storage
     *
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
     *
     * @param $parent_id
     * @param $file
     * @return string
     */
    private function storeStoragePicture($parent_id, $file) {
        $path = Storage::disk('public')->putFile($this->getFilePath($parent_id), $file); // Automatically generate a unique ID for filename...
        $url = Storage::disk('public')->url($path); // Get the URL for a given file
        return $url;
    }
}
