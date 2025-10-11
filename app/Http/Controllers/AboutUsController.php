<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use App\Models\Course;

class AboutUsController extends Controller
{
    public function __invoke()
    {
        $whoWeAre = "HSE.AZ LLC (www.HSE.az) founded on January 13, 2018, it is a web portal that carries out awareness activities on health, occupational safety and environmental protection in various ways. The portal operates under the slogan “For healthier and safer future” in the form of “Limited Liability Company” (LLC) with state registration number 2904927371.";

        $missionVision = [
            'vision'  => "Our vision – to contribute to the formation of a disease-free, happy working environment in the World, and to educate people on occupational health, safety and the environment.",
            'mission' => "Our Mission – We believe that all occupational accidents and illnesses are preventable. We also believe that using the right and quality awareness methods can help people become more aware of the dangers and risks, develop a risk-based approach and behavior, and thus avoid serious accidents or reduce their consequences. In this sense, in order to achieve targets, our mission is to carry out awareness-raising activities in various ways and to have a leading position in the field of education in region.",
        ];

        // NOTE: cədvəldə 'title' yoxdur, 'name' var
        $accreditations = Accreditation::query()
            ->select('id', 'description', 'imageUrl', 'created_at')
            ->latest()
            ->take(8)
            ->get();

        $courses = Course::query()
            ->type(Course::TYPE_COURSE)
            ->latest()
            ->take(3)
            ->get();

        $services = Course::query()
            ->type(Course::TYPE_SERVICE)
            ->select('id', 'name')
            ->latest()
            ->take(20)
            ->get();

        return view('educve.about-us', compact(
            'whoWeAre', 'missionVision', 'accreditations', 'courses', 'services'
        ));
    }
}
