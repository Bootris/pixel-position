<x-layout>
    <x-page-heading>My Jobs</x-page-heading>

    <div class="grid lg:grid-cols-3 gap-8 mt-6">
  

        @forelse ($jobs as $job)
            <x-job-card :job="$job" />
        @empty
            <p>You have not created any jobs yet.</p>
        @endforelse
    </div>
</x-layout>
