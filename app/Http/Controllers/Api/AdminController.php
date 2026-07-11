<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Expert;
use App\Models\Disease;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $admin = Admin::where("email", $request->email)->first();

        if(!$admin || !Hash::check($request->password, $admin->password)){
            return response()->json([
                "success" => false,
                "message" => "Invalid credentials"
            ], 401);
        }

        return response()->json([
            "success" => true,
            "message" => "Login Successful",
            "admin" => $admin
        ]);
    }

    public function dashboard()
{
    $totalExperts = Expert::count();

    $totalDiseases = Disease::count();

    $totalPlants = Disease::distinct('plant_name')->count('plant_name');

    return response()->json([
        "success" => true,
        "data" => [
            "totalExperts" => $totalExperts,
            "totalDiseases" => $totalDiseases,
            "totalPlants" => $totalPlants
        ]
    ]);
}

public function experts()
{
    $experts = \App\Models\Expert::latest()->get();

    return response()->json([
        "success" => true,
        "data" => $experts
    ]);
}

public function deleteExpert($id)
{
    $expert = \App\Models\Expert::find($id);

    if (!$expert) {
        return response()->json([
            "success" => false,
            "message" => "Expert not found"
        ], 404);
    }

    $expert->delete();

    return response()->json([
        "success" => true,
        "message" => "Expert deleted successfully"
    ]);
}

public function diseases()
{
    $diseases = \App\Models\Disease::with('expert')->latest()->get();

    return response()->json([
        "success" => true,
        "data" => $diseases
    ]);
}

public function deleteDisease($id)
{
    $disease = \App\Models\Disease::find($id);

    if (!$disease) {
        return response()->json([
            "success" => false,
            "message" => "Disease not found"
        ],404);
    }

    $disease->delete();

    return response()->json([
        "success" => true,
        "message" => "Disease deleted successfully"
    ]);
}

}
