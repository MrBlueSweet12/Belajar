<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // GET /api/menu
    public function index()
    {
        return response()->json(Menu::all());
    }
}
