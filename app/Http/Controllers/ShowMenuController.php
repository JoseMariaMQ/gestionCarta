<?php

namespace App\Http\Controllers;

use App\Models\Dessert;
use App\Models\Dish;
use App\Models\Drink;
use App\Models\Section;
use Illuminate\Http\Request;

class ShowMenuController extends Controller
{

    public function listDishes(Request $request) {
        return Dish::with('allergens')->get()->append('section')->append('picture');
    }

    public function listDesserts(Request $request) {
        return Dessert::with('allergens')->get()->append('section')->append('picture');
    }

    public function listDrinks(Request $request) {
        return Drink::all()->append('section')->append('picture');
    }
}
