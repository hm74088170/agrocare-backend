<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'firebase_uid' => 'required|string|unique:experts,firebase_uid',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:experts,email',
            'specialization' => 'required|string|max:255',
        ]);

        $expert = Expert::create($validated);

        return response()->json([
            'success' => true,
            'message'=> 'Expert registered successfully',
            'data' => $expert
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'firebase_uid' => 'required|string'
        ]);

        $expert = Expert::where('firebase_uid',
        $request->firebase_uid)->first();

        if(!$expert){
            return response()->json([
                'success' => false,
                'message' => 'Expert not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'expert' => $expert
        ]);
    }
}
