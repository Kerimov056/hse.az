<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResourceType;
use Illuminate\Http\Request;

class ResourceTypesController extends Controller
{
    public function index()
    {
        $types = ResourceType::orderBy('name')->get();
        return view('admin.resource_types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:120','unique:resource_types,name']
        ]);

        ResourceType::create($data);
        return redirect()->route('admin.resource-types.index')->with('ok','Tip yaradıldı');
    }

    public function destroy(ResourceType $resource_type)
    {
        $resource_type->delete();
        return redirect()->route('admin.resource-types.index')->with('ok','Silindi');
    }

    public function show(ResourceType $resource_type)
    {
        // sadə read — tipin detalları və resurs sayı
        $resource_type->loadCount('resources');
        return view('admin.resource_types.show', compact('resource_type'));
    }
}
