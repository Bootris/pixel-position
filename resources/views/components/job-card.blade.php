@props(['job'])

<x-panel class="flex flex-col text-center">
    <a href="{{ $job->url }}" class="">
        <div class="self-start text-sm">{{ $job->employer->name }}</div>

        <section class="py-8">
            <h3 class="group-hover:text-blue-800 text-xl font-bold transition-colors duration-300">
                {{ $job->title }}
            </h3>
            <p class="text-sm mt-4">{{ $job->salary }}</p>
        </section>
    </a>

    <div class="flex justify-between items-center mt-auto">
        <section>
            @foreach($job->tags as $tag)
                <x-tag :$tag size="small" />
            @endforeach
        </section>

        <x-employer-logo :employer="$job->employer" :width="42" />
    </div>
</x-panel>
