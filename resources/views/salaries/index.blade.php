<x-layout>
    <section>
        <x-section-heading>Job Salaries</x-section-heading>

        <div class="mt-6 space-y-6">
            @foreach($jobs as $job)
                <div class="p-6 bg-gray-800 rounded-lg shadow-md flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">{{ $job->title }}</h3>
                        <p class="text-sm text-gray-400">{{ $job->employer->name }}</p>
                        <p class="text-sm text-gray-200">{{( $job->salary) }}</p>
                    </div>
                    <div>
                        @foreach($job->tags as $tag)
                            <x-tag :tag="$tag" size="small" />
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layout>