@props(['schools'])

<div {{ $attributes->merge(['class' => 'bg-white shadow overflow-hidden sm:rounded-md']) }}>
    <ul class="divide-y divide-gray-200">
        @foreach ($schools as $school)
            <li>
                <a href="https://www.google.com/maps/search/?api=1&query={{ Str::slug($school->name, '+') }}" class="block hover:bg-gray-50">
                    <div class="flex items-center px-4 py-4 sm:px-6">
                        <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                            <div>
                                <p class="text-sm font-medium text-indigo-600 truncate">
                                    {{ $school->name }}
                                </p>
                                <p class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="truncate">
                                        {{ $school->city }}, {{ $school->state }}
                                    </span>
                                </p>
                            </div>
                            <div class="hidden md:block">
                                <div>
                                    <p class="text-sm text-gray-900">
                                        <strong>NCES ID:</strong>
                                        {{ $school->district_id . '' . $school->school_id }}
                                    </p>
                                    <p class="mt-2 text-sm text-gray-900">
                                        <strong>Locale:</strong>
                                        {{ $school->getLocaleDescription() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
