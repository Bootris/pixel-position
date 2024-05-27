<div class="p-6 bg-gray-800 rounded-lg shadow-md flex justify-between items-center">
    <div>
        <h3 class="text-lg font-bold">{{ $job->title }}</h3>
        <p class="text-sm text-gray-400">{{ $job->employer->name }}</p>
        <p class="text-sm text-gray-200">{{($job->salary) }} USD</p>
    </div>

</div>
