<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct(Request $request)
    {
        // Проверка API-ключа
        if ($request->header('X-API-KEY') !== env('API_KEY', 'default-key')) {
            abort(401, 'Unauthorized: Invalid API Key');
        }
    }

    // Список всех видов деятельности
    public function index()
    {
        $activities = Activity::all();

        if ($activities->isEmpty()) {
            return response()->json(['message' => 'No activities found'], 404);
        }

        return response()->json($activities);
    }
}
