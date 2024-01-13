<?php

namespace App\Http\Controllers;


use App\Providers\ChartsServiceProvider;
use App\ChartClass\LaravelChart;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
     * @throws \Exception
     *
     * source https://github.com/LaravelDaily/laravel-charts
     */
    public function index()
    {
        $chart_options = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',//group_by_date, group_by_string or group_by_relationship;
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',//"line", "bar", "pie";
        ];

        $chart1 = new LaravelChart($chart_options);

        $menuVar = ['Kalendarz', 'Dodaj osobe','Dodaj Firme'];
        return view('crm.chart.chart', compact('chart1','menuVar'));
    }
}
