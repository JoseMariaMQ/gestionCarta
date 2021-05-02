<?php

namespace App\Http\Controllers;

use App\Models\Dessert;
use App\Models\Dish;
use App\Models\Drink;
use App\Models\Section;
use Illuminate\Http\Request;

class ShowMenuController extends Controller
{
    public function listSections(Request $request) {
        return Section::orderBy('order', 'ASC')->get()->append('picture')->append('dishes')->append('desserts')->append('drinks');
    }
}
