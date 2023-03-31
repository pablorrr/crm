<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('CRM') }}
        </h2>
    </x-slot>

    <div class="py-12"></div>
    <div class="flex space-x-2 justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{route('persons.create')}}">
            <button
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md
                 font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none
                  focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                Dodaj osobę
            </button>
            </a>
            <a href="{{route('companies.create')}}">
            <button
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md
                 font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none
                  focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                Dodaj firmę
            </button>
            </a>
        </div>
    </div>
    <div class="py-12">


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                <ul class="list-none">
                    <li>Now this is a story all about how, my life got flipped-turned upside down</li>
                    <li>Now this is a story all about how, my life got flipped-turned upside down</li>
                    <li>Now this is a story all about how, my life got flipped-turned upside down</li>
                    <li>Now this is a story all about how, my life got flipped-turned upside down</li>
                    <!-- ... -->
                </ul>


            </div>

        </div>
    </div>
</x-app-layout>
