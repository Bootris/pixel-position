<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\View\View;

class SalariesController extends Controller
{
    public function index(): View
    {
        $jobs = Job::with(['employer', 'tags'])
            ->orderBy('salary', 'desc')
            ->get();

        return view('salaries.index', [
            'jobs' => $jobs,
        ]);
    }
}
