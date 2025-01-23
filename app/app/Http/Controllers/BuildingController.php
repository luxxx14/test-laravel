<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Building API", version="1.0")
 * @OA\Server(url="http://localhost/api")
 */
class BuildingController extends Controller
{
    public function __construct(Request $request)
    {
        // Проверка API-ключа
        if ($request->header('X-API-KEY') !== env('API_KEY', 'default-key')) {
            abort(401, 'Unauthorized: Invalid API Key');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/buildings",
     *     summary="Список всех зданий",
     *     description="Список всех зданий",
     *     tags={"Building"},
     *     @OA\Response(
     *         response=200,
     *         description="Список всех зданий",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Building")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No buildings found"
     *     ),
     * )
     */
    public function index()
    {
        $buildings = Building::all();
        
        if ($buildings->isEmpty()) {
            return response()->json(['message' => 'No buildings found'], 404);
        }

        return response()->json($buildings);
    }
}
