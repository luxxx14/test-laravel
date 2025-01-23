<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function __construct(Request $request)
    {
        // Проверка API-ключа
        if ($request->header('X-API-KEY') !== env('API_KEY', 'default-key')) {
            abort(401, 'Unauthorized: Invalid API Key');
        }
    }

    // Список всех зданий
    public function index()
    {
        $buildings = Building::all();
        
        if ($buildings->isEmpty()) {
            return response()->json(['message' => 'No buildings found'], 404);
        }

        return response()->json($buildings);
    }
}
