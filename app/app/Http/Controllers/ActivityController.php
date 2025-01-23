<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Activity API", version="1.0")
 * @OA\Server(url="http://localhost/api")
 */
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
        /**
     * @OA\Get(
     *     path="/api/activities",
     *     summary="Get all activities",
     *     description="Retrieve a list of all activities.",
     *     tags={"Activity"},
     *     @OA\Response(
     *         response=200,
     *         description="List of activities",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Activity")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No activities found"
     *     ),
     * )
     */
    public function index()
    {
        $activities = Activity::all();

        if ($activities->isEmpty()) {
            return response()->json(['message' => 'No activities found'], 404);
        }

        return response()->json($activities);
    }
}
