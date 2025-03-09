<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeCreateRequest;
use App\Http\Requests\AttributeUpdateRequest;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        return response()->json(["attributes" => Attribute::all()]);
    }

    public function show($id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            return response()->json(["attribute" => $attribute]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'attribute not found'
            ], 404);
        }
    }

    public function store(AttributeCreateRequest $request)
    {
        $attribute = Attribute::create($request->toArray());

        return response()->json(["message" => "Attribute created successfully","attribute" => $attribute], 201);
    }

    public function update($id,AttributeUpdateRequest $request)
    {
        try {
            $attribute = Attribute::findOrFail($id);

            $attribute->update($request->toArray());

            return response()->json(["message" => "Attribute updated successfully","attribute" =>$attribute], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'project not found'
            ], 404);
        }

    }

    public function destroy($id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            $attribute->delete();
            return response()->json(['message' => 'Attribute deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'attribute not found'
            ], 404);
        }

    }
}
