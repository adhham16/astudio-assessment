<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\AttributeValue;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('attributeValues.attribute');

        if ($filters = $request->query('filters')) {
            foreach ($filters as $key => $value) {
                if ($key === 'name') {
                    $query->where('name', 'LIKE', "%$value%");
                } else {
                    $query->whereHas('attributeValues', function ($q) use ($key, $value) {
                        $q->whereHas('attribute', function ($q2) use ($key) {
                            $q2->where('name', $key);
                        })->where('value', 'LIKE', "%$value%");
                    });
                }
            }
        }

        return response()->json(["projects" => $query->get()]);
    }


    public function show($id)
    {
        try {
            $project = Project::findOrFail($id);
            return response()->json(["project" => $project]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'project not found'
            ], 404);
        }
    }

    public function store(ProjectCreateRequest $request)
    {
        $project = Project::create($request->toArray());

        return response()->json(["message" => "Project created successfully","project" => $project], 201);
    }

    public function update($id,ProjectUpdateRequest $request)
    {
        try {
            $project = Project::findOrFail($id);

            $project->update($request->toArray());

            return response()->json(["message" => "Project updated successfully","project" =>$project], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'project not found'
            ], 404);
        }

    }

    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();
            return response()->json(['message' => 'Project deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'project not found'
            ], 404);
        }

    }

    public function setAttributes($id,Request $request)
    {
        $request->validate([
            'project_attributes' => 'required|array',
            'project_attributes.*.attribute_id' => 'required|exists:attributes,id',
            'project_attributes.*.value' => 'required|string'
        ]);
        foreach ($request->project_attributes as $attr) {
            AttributeValue::updateOrCreate(
                ['attribute_id' => $attr['attribute_id'], 'entity_id' => $id],
                ['attribute_id' => $attr['attribute_id'], 'entity_id' => $id,'value' => $attr['value']]
            );
        }
        return response()->json(['message' => 'Attributes updated successfully']);
    }
}
