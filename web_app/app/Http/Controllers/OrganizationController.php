<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Building;
use App\Models\Activity;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Organizations",
 *     description="API для работы с организациями"
 * )
 */
class OrganizationController extends Controller
{
  /**
   * Список всех организаций, находящихся в конкретном здании
   * 
   * @OA\Get(
   *     path="/api/organizations/building/{building_id}",
   *     summary="Получить список организаций в здании",
   *     tags={"Organizations"},
   *     @OA\Parameter(
   *         name="building_id",
   *         in="path",
   *         description="ID здания",
   *         required=true,
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Список организаций",
   *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
   *     ),
   *     @OA\Response(response=404, description="Здание не найдено")
   * )
   */
  public function getOrganizationsByBuilding($building_id)
  {
    $building = Building::find($building_id);

    if (!$building) {
      return response()->json(['message' => 'Здание не найдено'], 404);
    }

    $organizations = Organization::where('building_id', $building_id)->get();
    return response()->json($organizations);
  }

  /**
   * Список всех организаций, относящихся к виду деятельности
   * 
   * @OA\Get(
   *     path="/api/organizations/activity/{activity_id}",
   *     summary="Получить список организаций по виду деятельности",
   *     tags={"Organizations"},
   *     @OA\Parameter(
   *         name="activity_id",
   *         in="path",
   *         description="ID вида деятельности",
   *         required=true,
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Список организаций",
   *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
   *     ),
   *     @OA\Response(response=404, description="Вид деятельности не найден")
   * )
   */
  public function getOrganizationsByActivity($activity_id)
  {
    $activity = Activity::find($activity_id);

    if (!$activity) {
      return response()->json(['message' => 'Вид деятельности не найден'], 404);
    }

    $organizations = Organization::whereHas('activities', function($query) use ($activity_id) {
      $query->where('activity_id', $activity_id);
    })->get();

    return response()->json($organizations);
  }

  /**
   * Список организаций в заданном радиусе или области
   * 
   * @OA\Get(
   *     path="/api/organizations/nearby",
   *     summary="Получить список организаций по географическому расположению",
   *     tags={"Organizations"},
   *     @OA\Parameter(
   *         name="latitude",
   *         in="query",
   *         description="Широта точки",
   *         required=true,
   *         @OA\Schema(type="number", format="float")
   *     ),
   *     @OA\Parameter(
   *         name="longitude",
   *         in="query",
   *         description="Долгота точки",
   *         required=true,
   *         @OA\Schema(type="number", format="float")
   *     ),
   *     @OA\Parameter(
   *         name="radius",
   *         in="query",
   *         description="Радиус поиска в километрах",
   *         required=true,
   *         @OA\Schema(type="number", format="float")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Список организаций",
   *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
   *     ),
   *     @OA\Response(response=404, description="Организации не найдены")
   * )
   */
  public function getOrganizationsNearby(Request $request)
  {
    $latitude = $request->query('lat');
    $longitude = $request->query('lon');
    $radius = $request->query('radius');

    $buildings = Building::whereRaw("
          ST_Distance_Sphere(
              point(longitude, latitude), 
              point(?, ?)
          ) <= ? * 1000
      ", [$longitude, $latitude, $radius])
      ->get();

    $organizations = $buildings->flatMap(function($building) {
      return $building->organizations;
    });

    return response()->json($organizations);
  }

  /**
   * Получить организацию по её идентификатору
   * 
   * @OA\Get(
   *     path="/api/organizations/{id}",
   *     summary="Получить организацию по ID",
   *     tags={"Organizations"},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         description="ID организации",
   *         required=true,
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Информация об организации",
   *         @OA\JsonContent(ref="#/components/schemas/Organization")
   *     ),
   *     @OA\Response(response=404, description="Организация не найдена")
   * )
   */
  public function show($id)
  {
    $organization = Organization::find($id);

    if (!$organization) {
      return response()->json(['message' => 'Организация не найдена'], 404);
    }

    return response()->json($organization);
  }

  /**
   * Поиск организаций по названию
   * 
   * @OA\Get(
   *     path="/api/organizations/search/name/{name}",
   *     summary="Поиск организации по названию",
   *     tags={"Organizations"},
   *     @OA\Parameter(
   *         name="name",
   *         in="path",
   *         description="Название организации",
   *         required=true,
   *         @OA\Schema(type="string")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Список организаций",
   *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
   *     ),
   *     @OA\Response(response=404, description="Организации не найдены")
   * )
   */
  public function searchByName($name)
  {
    $organizations = Organization::where('name', 'like', "%$name%")->get();

    if ($organizations->isEmpty()) {
      return response()->json(['message' => 'Организации не найдены'], 404);
    }

    return response()->json($organizations);
  }

  /**
   * Поиск организаций по виду деятельности с ограничением на 3 уровня вложенности
   * 
   * @OA\Get(
   *     path="/api/organizations/search/activity/{activity_name}",
   *     summary="Поиск организаций по виду деятельности",
   *     tags={"Organizations"},
   *     @OA\Parameter(
   *         name="activity_name",
   *         in="path",
   *         description="Название вида деятельности",
   *         required=true,
   *         @OA\Schema(type="string")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Список организаций",
   *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
   *     ),
   *     @OA\Response(response=404, description="Организации не найдены")
   * )
   */
  public function searchByActivity(Request $request, $activity_name)
  {
    // Получаем основной вид деятельности
    $activity = Activity::where('name', $activity_name)->first();

    if (!$activity) {
      return response()->json(['message' => 'Вид деятельности не найден'], 404);
    }

    // Получаем все дочерние виды деятельности до 3 уровней
    $activities = $this->getActivitiesByLevel($activity, 3);

    // Составляем список всех организаций, относящихся к этим видам деятельности
    $organizations = Organization::whereHas('activities', function($query) use ($activities) {
      $query->whereIn('activity_id', $activities);
    })->get();

    if ($organizations->isEmpty()) {
      return response()->json(['message' => 'Организации не найдены'], 404);
    }

    return response()->json($organizations);
  }

  private function getActivitiesByLevel(Activity $activity, int $maxLevel, $currentLevel = 1)
  {
    // Останавливаем рекурсию, если достигли максимального уровня
    if ($currentLevel > $maxLevel) {
      return [];
    }

    // Получаем текущую активность и все её дочерние
    $activities = [$activity->id];
    $children = $activity->children;

    foreach ($children as $child) {
      $activities = array_merge($activities, $this->getActivitiesByLevel($child, $maxLevel, $currentLevel + 1));
    }

    return $activities;
  }
}
