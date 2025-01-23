<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Activity;
use App\Models\Building;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function __construct(Request $request)
    {
        // Проверка API-ключа
        if ($request->header('X-API-KEY') !== env('API_KEY', 'default-key')) {
            abort(401, 'Unauthorized: Invalid API Key');
        }
    }

    // Список всех организаций в конкретном здании
    public function getOrganizationsByBuilding($buildingId)
    {
        $building = Building::find($buildingId);
        if (!$building) {
            return response()->json(['error' => 'Building not found'], 404);
        }

        $organizations = Organization::where('building_id', $buildingId)->get();
        return response()->json($organizations);
    }

    // Список организаций по виду деятельности
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

    // Список организаций в заданном радиусе
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

    // Получить информацию об организации по ID
    public function getOrganizationById(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:organizations,id',
        ]);

        $organization = Organization::with(['building', 'activities'])->findOrFail($request->id);

        return response()->json($organization);
    }

    // Поиск организаций по виду деятельности (включая вложенные)
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

    // Поиск организаций по названию
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
