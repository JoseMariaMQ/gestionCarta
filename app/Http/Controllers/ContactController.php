<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    /**
     * List all contact
     * @param Request $request
     * @return Contact[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request) {
        return Contact::all();
    }

    /**
     * Store a contact
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'hidden' => 'boolean'
        ]);

        Contact::create($request->all());
        return $this->successResponse(Response::HTTP_CREATED);
    }

    /**
     * Get a contact
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function show(Request $request, $id) {
        return Contact::find($id);
    }

    /**
     * Update all contact's fields
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
        $contact = Contact::findOrFail($id);
        $request->validate([
            'name' => 'string|max:255',
            'url' => 'string|max:255',
            'hidden' => 'boolean'
        ]);
        $contact->update($request->all());
        return $this->successResponse(Response::HTTP_OK);
    }

    /**
     * Delete a contact
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $id) {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return $this->successResponse(Response::HTTP_OK);
    }
}
