<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;

class CourseRegistrationAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $courseId = $request->get('course_id');

        $items = CourseRegistration::query()
            ->with(['course:id,name,type'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('first_name', 'like', "%{$q}%")
                       ->orWhere('surname', 'like', "%{$q}%")
                       ->orWhere('patronymic', 'like', "%{$q}%")
                       ->orWhere('certificate_name', 'like', "%{$q}%")
                       ->orWhere('business_email', 'like', "%{$q}%")
                       ->orWhere('mobile_phone', 'like', "%{$q}%")
                       ->orWhere('id_card_number', 'like', "%{$q}%")
                       ->orWhere('requested_product_service', 'like', "%{$q}%");
                });
            })
            ->when($courseId, function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $courses = Course::query()
            ->where('type', Course::TYPE_COURSE)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.course_registrations.index', compact('items', 'q', 'courseId', 'courses'));
    }

    public function show(CourseRegistration $courseRegistration)
    {
        $courseRegistration->load(['course:id,name,type,courseUrl']);

        return view('admin.course_registrations.show', [
            'it' => $courseRegistration,
        ]);
    }

    public function destroy(CourseRegistration $courseRegistration)
    {
        $courseRegistration->delete();

        return redirect()
            ->route('admin.course-registrations.index')
            ->with('ok', 'Qeydiyyat silindi');
    }
}
