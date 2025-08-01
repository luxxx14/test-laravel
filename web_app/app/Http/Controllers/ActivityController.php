<?php

namespace App\Http\Controllers;

use App\Models\Activity;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Activities",
 *     description="API для работы с деятельностью"
 * )
 */
class ActivityController extends Controller
{
  /**
   * Получить список всех видов деятельности
   * 
   * @OA\Get(
   *     path="/api/activities",
   *     summary="Получить список всех видов деятельности",
   *     tags={"Activities"},
   *     @OA\Response(
   *         response=200,
   *         description="Список видов деятельности",
   *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Activity"))
   *     ),
   *     @OA\Response(response=500, description="Ошибка сервера")
   * )
   */
  public function index()
  {
    $activities = Activity::all();
    return response()->json($activities);
  }

  /**
   * Получить информацию о виде деятельности по ID
   * 
   * @OA\Get(
   *     path="/api/activities/{id}",
   *     summary="Получить вид деятельности по ID",
   *     tags={"Activities"},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         description="ID вида деятельности",
   *         required=true,
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Информация о виде деятельности",
   *         @OA\JsonContent(ref="#/components/schemas/Activity")
   *     ),
   *     @OA\Response(response=404, description="Вид деятельности не найден")
   * )
   */
  public function show($id)
  {
    $activity = Activity::find($id);

    if (!$activity) {
      return response()->json(['message' => 'Вид деятельности не найден'], 404);
    }

    return response()->json($activity);
  }
}
