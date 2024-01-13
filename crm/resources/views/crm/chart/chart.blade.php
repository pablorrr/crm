@extends('layouts.crm.layout')

@section('title', 'Wykres')

@section('content')
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">

                            <h1>{{$chart1->options['chart_title'] }}</h1>

                            {!! $chart1->renderHtml() !!}
                        </div>
                        {!! $chart1->renderChartJsLibrary() !!}
                        {!! $chart1->renderJs() !!}
                    </div>
                </div>
            </div>
        </div>


        <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </div>
    </div>
@endsection
