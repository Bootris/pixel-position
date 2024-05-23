<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $jobs = Job::latest()->with(['employer', 'tags'])->get()->groupBy('featured');

        return view('jobs.index', [
            'jobs' => $jobs[0],
            'featuredJobs' => $jobs[1],
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function view(Request $request): View
    {
        $employerId = auth()->user()->employer->id;

        $jobs = Job::where('employer_id', $employerId)
            ->latest()
            ->with(['employer', 'tags'])
            ->get();

        return view('jobs.me', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'title' => ['required'],
            'salary' => ['required'],
            'location' => ['required'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['required', 'active_url'],
            'tags' => ['nullable'],
        ]);

        $attributes['featured'] = $request->has('featured');

        $job = Auth::user()->employer->jobs()->create(Arr::except($attributes, 'tags'));

        if ($attributes['tags'] ?? false) {
            foreach (explode(',', $attributes['tags']) as $tag) {
                $job->addTag($tag);
            }
        }

        return redirect('/');
    }

    public function edit(Job $job): View
    {
        if ($job->employer->user->isNot(Auth::user())) {
            abort(403);
        }

        return view('jobs.edit', ['job' => $job]);
    }

    // Request $request switch with custom FormRequest class
    public function update(Request $request, Job $job): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'min:3'],
            'salary' => 'required',
            'location' => 'required',
            'tags' => 'nullable|string',
        ]);

        $job->update([
            'title' => $request->input('title'),
            'salary' => $request->input('salary'),
            'location' => $request->input('location'),
        ]);

        // Get and process the tags input
        $tagsInput = $request->input('tags');
        if ($tagsInput) {
            // Split on commas and remove whitespace
            $tagNames = explode(',', str_replace(' ', '', $tagsInput));

            // Retrieve or create tags
            $tags = collect($tagNames)->map(function($tagName) {
                return Tag::firstOrCreate(['name' => $tagName])->id;
            });

            // Sync the tags with the job
            $job->tags()->sync($tags);
        } else {
            // If no tags are provided, detach all tags from the job
            $job->tags()->sync([]);
        }

        // Redirect to the job page
        return redirect('jobs/');
    }


    public function destroy(Job $job)
    {
        $job->delete();

        return response()->json(['message' => 'Job deleted successfully'], 200);

    }
}
