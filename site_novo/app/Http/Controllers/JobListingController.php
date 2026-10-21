<?php

namespace App\Http\Controllers;

use App\Models\JobListing;

class JobListingController extends Controller
{
    public function index()
    {
        $jobs = JobListing::published()->active()->orderBy('published_at', 'desc')->get();

        return view('jobs.index', ['jobs' => $jobs]);
    }
}
