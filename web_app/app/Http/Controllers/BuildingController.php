<?php

namespace App\Http\Controllers;

use App\Models\Building;

/**
 * @OA\Tag(
 *     name="Buildings",
 *     description="API для работы с зданиями"
 * )
 */
class BuildingController extends Controller
{
  /**
   * Получить список всех зданий
   * 
   * @OA\Get(
   *     path="/api/buildings",
   *     summary="Получить список всех зданий",
   *     tags={"Buildings"},
   *     @OA\Response(
   *         response=200,
   *         description="Список зданий",
   *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Building"))
   *     ),
   *     @OA\Response(response=500, description="Ошибка сервера")
   * )
   */
  public function index()
  {
    $buildings = Building::all();
    return response()->json($buildings);
  }

  /**
   * Получить информацию о здании по его ID
   * 
   * @OA\Get(
   *     path="/api/buildings/{id}",
   *     summary="Получить здание по ID",
   *     tags={"Buildings"},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         description="ID здания",
   *         required=true,
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Информация о здании",
   *         @OA\JsonContent(ref="#/components/schemas/Building")
   *     ),
   *     @OA\Response(response=404, description="Здание не найдено")
   * )
   */
  public function show($id)
  {
    $building = Building::find($id);

    if (!$building) {
      return response()->json(['message' => 'Здание не найдено'], 404);
    }

    return response()->json($building);
  }
}
