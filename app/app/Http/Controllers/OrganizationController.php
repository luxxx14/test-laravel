<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Activity;
use App\Models\Building;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Organization API", version="1.0", description="API для работы с организациями, зданиями и деятельностями.")
 * @OA\Server(url="http://localhost/api", description="Основной сервер API")
 */
class OrganizationController extends Controller
{
    
    /**
     * @OA\Get(
     *     path="/api/organizations/building/{buildingId}",
     *     summary="Список всех организаций в здании",
     *     description="Получить список всех организаций, находящихся в здании по его ID",
     *     @OA\Parameter(
     *         name="buildingId",
     *         in="path",
     *         required=true,
     *         description="ID здания",
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
    public function getOrganizationsByBuilding($buildingId)
    {
        $building = Building::find($buildingId);
        if (!$building) {
            return response()->json(['error' => 'Building not found'], 404);
        }

        $organizations = Organization::where('building_id', $buildingId)->get();
        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/activity/{activityId}",
     *     summary="Список организаций по виду деятельности",
     *     description="Получить список организаций, которые выполняют указанный вид деятельности",
     *     @OA\Parameter(
     *         name="activityId",
     *         in="path",
     *         required=true,
     *         description="ID вида деятельности",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций по виду деятельности",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *     ),
     *     @OA\Response(response=404, description="Вид деятельности не найден")
     * )
     */
    public function getOrganizationsByActivity($activityId)
    {
        $activity = Activity::find($activityId);
        if (!$activity) {
            return response()->json(['error' => 'Activity not found'], 404);
        }

        $organizations = Organization::whereHas('activities', function ($query) use ($activityId) {
            $query->where('id', $activityId);
        })->get();

        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/radius",
     *     summary="Список организаций в радиусе",
     *     description="Получить список организаций в заданном радиусе от определенной точки",
     *     @OA\Parameter(
     *         name="latitude",
     *         in="query",
     *         required=true,
     *         description="Широта точки",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="longitude",
     *         in="query",
     *         required=true,
     *         description="Долгота точки",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="radius",
     *         in="query",
     *         required=true,
     *         description="Радиус поиска в метрах",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций в радиусе",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *     ),
     *     @OA\Response(response=400, description="Неверные параметры")
     * )
     */
    public function getOrganizationsByRadius(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric|min:0',
        ]);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');

        $organizations = Organization::whereHas('building', function ($query) use ($latitude, $longitude, $radius) {
            $query->whereRaw("ST_Distance_Sphere(
                point(longitude, latitude),
                point(?, ?)
            ) <= ?", [$longitude, $latitude, $radius]);
        })->get();

        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/{id}",
     *     summary="Получить организацию по ID",
     *     description="Получить информацию о организации по её ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID организации",
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
    public function getOrganizationById(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:organizations,id',
        ]);

        $organization = Organization::with(['building', 'activities'])->findOrFail($request->id);

        return response()->json($organization);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/activity/tree/{activityId}",
     *     summary="Поиск организаций по виду деятельности с учетом вложенности",
     *     description="Поиск организаций по виду деятельности, включая вложенные виды деятельности",
     *     @OA\Parameter(
     *         name="activityId",
     *         in="path",
     *         required=true,
     *         description="ID вида деятельности",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций с учетом вложенности",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *     ),
     *     @OA\Response(response=404, description="Вид деятельности не найден")
     * )
     */
    public function searchOrganizationsByActivity(Request $request)
    {
        $request->validate([
            'activityName' => 'required|string|max:255',
        ]);

        $activityName = $request->input('activityName');

        $activities = Activity::where('name', 'LIKE', "%{$activityName}%")
            ->where('level', '<=', 3) // Ограничение вложенности
            ->pluck('id');

        if ($activities->isEmpty()) {
            return response()->json(['error' => 'No activities found'], 404);
        }

        $organizations = Organization::whereHas('activities', function ($query) use ($activities) {
            $query->whereIn('id', $activities);
        })->get();

        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/search",
     *     summary="Поиск организаций по названию",
     *     description="Поиск организаций по названию",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         description="Название организации",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций по названию",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *     ),
     *     @OA\Response(response=404, description="Организация не найдена")
     * )
     */
    public function searchOrganizationsByName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $name = $request->input('name');

        $organizations = Organization::where('name', 'LIKE', "%{$name}%")->get();

        if ($organizations->isEmpty()) {
            return response()->json(['error' => 'No organizations found'], 404);
        }

        return response()->json($organizations);
    }
}
