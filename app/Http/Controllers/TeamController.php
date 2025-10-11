<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Team list (users)
    public function index(Request $request)
    {
        $q      = trim((string) $request->q);
        $gender = $request->gender;

        $teams = Team::query()
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('full_name', 'like', "%{$q}%")
                      ->orWhere('position',  'like', "%{$q}%");
                });
            })
            ->when(in_array($gender, ['male','female'], true), fn($qq)=>$qq->where('gender',$gender))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('educve.team-members', compact('teams','q','gender'));
    }

    // Team details (users)
    public function show(Team $team)
    {
        $skills = json_decode($team->skills_json ?? '[]', true) ?: [];
        return view('educve.team-details', compact('team','skills'));
    }
}
