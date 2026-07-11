<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public function index()
{
    $diseases = Disease::all();

    foreach ($diseases as $disease) {
        if ($disease->image) {
            $disease->image = asset('storage/' . $disease->image);
        }
    }

    return response()->json($diseases);
}

    public function show($id)
{
    $disease = Disease::findOrFail($id);

    if ($disease->image) {
        $disease->image = asset('storage/' . $disease->image);
    }

    return response()->json($disease);
}

    public function search(Request $request){
        $plant = $request->input('plant');
        $query = $request->input('q');

        $diseases = Disease::query()->when($plant, function ($q) use ($plant) {
            $q->where('plant_name', 'like', "%{$plant}%");
        })
        ->when($query, function($qBuilder) use ($query) {
            $qBuilder->where('symptoms', 'like', "%{$query}%");
        })
        ->get();
        return response()->json($diseases);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'disease_name' => 'required',
        'plant_name' => 'required',
        'symptoms' => 'required',
        'prevention' => 'required',
        'medicine' => 'required',
        'expert_id' => 'required|exists:experts,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    // Store image
    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store(
            'diseases',
            'public'
        );
    }

    // Create disease
    $disease = Disease::create([
        'disease_name' => $request->disease_name,
        'plant_name' => $request->plant_name,
        'symptoms' => $request->symptoms,
        'medicine' => $request->medicine,
        'prevention' => $request->prevention,
        'expert_id' => $request->expert_id,
        'image' => $imagePath
    ]);

    // Convert image path to public URL
    if ($imagePath) {
        $disease->image = asset('storage/' . $imagePath);
    }

    return response()->json([
        'success' => true,
        'message' => 'Disease added successfully',
        'data' => $disease
    ], 201);
}

    public function update(Request $request, $id)
{
    $disease = Disease::findOrFail($id);

    $validated = $request->validate([
    'disease_name' => 'required',
    'plant_name' => 'required',
    'symptoms' => 'required',
    'prevention' => 'required',
    'medicine' => 'required',
    'expert_id' => 'required|exists:experts,id',
    'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
]);

$imagePath = null;

if ($request->hasFile('image')) {

    $imagePath = $request->file('image')->store(
        'diseases',
        'public'
    );
}

    $disease->update($validated);

    return response()->json([
        "success" => true,
        "message" => "Disease updated successfully",
        "data" => $disease
    ]);
}

public function destroy($id)
{
    $disease = Disease::findOrFail($id);

    $disease->delete();

    return response()->json([
        "success" => true,
        "message" => "Disease deleted successfully"
    ]);
}

    public function expertDiseases($id)
{
    $diseases = Disease::where('expert_id', $id)->get();

    foreach ($diseases as $disease) {
        if ($disease->image) {
            $disease->image = asset('storage/' . $disease->image);
        }
    }

    return response()->json([
        "success" => true,
        "data" => $diseases
    ]);
}
}
