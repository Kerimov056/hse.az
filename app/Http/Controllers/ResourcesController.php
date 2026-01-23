<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ResourceItem;
use App\Models\ResourceType;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function index(Request $request)
    {
        $q        = trim((string)$request->query('q',''));
        $type_id  = (int)$request->query('type_id', 0);

        $holdingRaw = trim((string)$request->query('holding', ''));
        $holding    = $holdingRaw !== '' ? preg_replace('/\s+/u', ' ', $holdingRaw) : '';

        $query = ResourceItem::query()
            ->when($type_id > 0, fn($qq) => $qq->where('resource_type_id', $type_id))
            ->when($holding !== '', fn($qq) => $qq->where('holdingName', $holding))
            ->search($q)
            ->with('type');

        $resources = $query->latest()
            ->paginate(12)
            ->appends(['q'=>$q, 'type_id'=>$type_id, 'holding'=>$holding]);

        $types = ResourceType::orderBy('name')->get();

        // header dropdown üçün uniq holding list
        $holdings = ResourceItem::query()
            ->whereNotNull('holdingName')
            ->where('holdingName', '!=', '')
            ->select('holdingName')
            ->distinct()
            ->orderBy('holdingName')
            ->pluck('holdingName');

        return view('educve.resources', compact(
            'resources',
            'types',
            'q',
            'type_id',
            'holding',
            'holdings'
        ));
    }

    public function show(ResourceItem $resource)
    {
        $resource->increment('views');
        $resource->refresh();

        $related = ResourceItem::query()
            ->where('resource_type_id', $resource->resource_type_id)
            ->where('id', '!=', $resource->id)
            ->latest()
            ->take(6)
            ->get();

        return view('educve.resources-details', compact('resource', 'related'));
    }
}
