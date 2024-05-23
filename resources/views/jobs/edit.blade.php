<x-layout>
    <x-page-heading>Edit or Delete Job: {{$job->title}} </x-page-heading>

    <x-forms.form method="POST" action="{{ route('jobs.update', $job) }}">
        @csrf
        @method('PATCH')

        <x-forms.input label="Title" name="title" value="{{ $job->title }}" placeholder="CEO" />
        <x-forms.input label="Salary" name="salary" value="{{ $job->salary }}" placeholder="$90,000 USD" />
        <x-forms.input label="Location" name="location" value="{{ $job->location }}" placeholder="Winter Park, Florida" />

        <x-forms.select label="Schedule" name="schedule">
            <option value="Part Time" {{ $job->schedule == 'Part Time' ? 'selected' : '' }}>Part Time</option>
            <option value="Full Time" {{ $job->schedule == 'Full Time' ? 'selected' : '' }}>Full Time</option>
        </x-forms.select>

        <x-forms.input label="URL" name="url" value="{{ $job->url }}" placeholder="https://acme.com/jobs/ceo-wanted" />
        <x-forms.checkbox label="Feature (Costs Extra)" name="featured" {{ $job->featured ? 'checked' : '' }} />

        <x-forms.divider />

        <x-forms.input label="Tags (comma separated)" name="tags" value="{{ implode(', ', $job->tags->pluck('name')->toArray()) }}" placeholder="laracasts, video, education" />
        
        <div class="flex gap-x-2">
            <x-forms.button type="submit">Update</x-forms.button>
            <x-forms.button type="button" id="CANCEL" onclick="cancel()" class="bg-red-500 hover:bg-red-700 text-white">Cancel</x-forms.button>
            <x-forms.button type="button" id="DELETE" onclick="deleteJob({{ $job->id }})" class="bg-red-500 hover:bg-red-700 text-white ml-auto">Delete</x-forms.button>
        </div>
    </x-forms.form>

    @push('scripts')
        <script>
            async function deleteJob(id) {
                const baseUrl = 'http://127.0.0.1:8000';
                
                try {
                    const response = await axios.delete(`${baseUrl}/jobs/${id}/`, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    // success
                    window.location.replace(`${baseUrl}/jobs`);

                } catch (error) {
                    console.log('error', error);
                }
            }

            function cancel() {
                window.location.replace('http://127.0.0.1:8000/jobs');
            }
        </script>
    @endpush
    
</x-layout>
