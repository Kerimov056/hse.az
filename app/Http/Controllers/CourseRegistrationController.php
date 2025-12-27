<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;

class CourseRegistrationController extends Controller
{
    public function create(Course $course)
    {
        abort_unless($course->type === Course::TYPE_COURSE, 404);

        return view('educve.register', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        abort_unless($course->type === Course::TYPE_COURSE, 404);

        $data = $request->validate([
            'first_name'  => ['required', 'string', 'max:255'],
            'surname'     => ['required', 'string', 'max:255'],
            'patronymic'  => ['required', 'string', 'max:255'],
            'certificate_name' => ['required', 'string', 'max:255'],

            'birth_date'  => ['required', 'date'],
            'gender'      => ['required', 'in:male,female,other'],

            'id_card_number' => ['required', 'string', 'max:255'],

            'business_email' => ['required', 'email', 'max:255'],
            'telephone'      => ['nullable', 'string', 'max:255'],
            'mobile_phone'   => ['required', 'string', 'max:255'],
            'postal_code'    => ['nullable', 'string', 'max:50'],

            'company'   => ['nullable', 'string', 'max:255'],
            'position'  => ['nullable', 'string', 'max:255'],

            'requested_product_service' => ['required', 'string', 'max:255'],

            'requirements' => ['nullable', 'string'],
            'notes'        => ['nullable', 'string'],

            'remember_me'  => ['nullable', 'boolean'],
        ]);

        $data['remember_me'] = (bool) ($request->boolean('remember_me'));

        CourseRegistration::create([
            'course_id' => $course->id,
            ...$data,
        ]);

        return redirect()
            ->route('course-details', $course->id)
            ->with('ok', 'Registration submitted successfully.');
    }
}
