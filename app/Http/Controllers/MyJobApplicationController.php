<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class MyJobApplicationController extends Controller
{
    public function index()
    {
        return view('my_job_application.index', [
            'applications' => auth()
                ->user()
                ->jobApplication()
                ->with(['job' => fn($query) => $query->withCount('jobApplication')->withAvg('jobApplication','expected_salary')->withTrashed()
                , 'job.employer'])
                ->latest()
                ->get(),
        ]);
    }

    public function destroy(JobApplication $myJobApplication)
    {
        $myJobApplication->delete();

        return redirect()->back()->with('success','Job Application Remove');
    }
}
