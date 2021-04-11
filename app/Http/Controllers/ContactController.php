<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

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

    public function store(Request $request) {

    }

    public function show(Request $request) {

    }

    public function update(Request $request) {

    }

    public function delete(Request $request) {

    }
}
