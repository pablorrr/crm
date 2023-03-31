<?php

namespace App\ChartClass;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class LaravelChart
{

    public $options = [];
    private $datasets = [];

    /**
     * Group Periods
     */
    const GROUP_PERIODS = [
        'day' => 'Y-m-d',
        'week' => 'Y-W',
        'month' => 'Y-m',
        'year' => 'Y',
    ];

    /**
     * LaravelChart constructor.
     * @param $chart_options
     * @throws \Exception
     */
    public function __construct()
    {

        /**
         * https://www.php.net/manual/en/function.func-get-args.php
         * func_get_args() zamiana paramterow przyjmowanych przez metode na tablice
         * parametry nalezy zglaszac w wywolaniu metody nie w jej definicji!!!
         * tutaj : $chart1 = new LaravelChart($chart_options);
         */
        foreach (func_get_args() as $arg) {
            $this->options = $arg;
            //chart anme to to samo co chart title , formatowanie na przujazny slug njprwd uzycie w uri
            $this->options['chart_name'] = strtolower(Str::slug($arg['chart_title'], '_'));
            $this->datasets[] = $this->prepareData();
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function prepareData()
    {
        $this->validateOptions($this->options);

        try {//sprawdz czy istnieje podana klasa danego modelu
            if (!class_exists($this->options['model'])) {
                return [];
            }

            $dataset = [];
            /**
             *
             * conditions (optional, only for line chart type) - array of conditions (name + raw condition + color) for multiple datasets;
             * ?? - operator  koalescencyjny
             * $this->options['conditions'] - jesli opcja ma wartosc null
             * tyo ma przyjac tablice wielowymiarowa o indexie glownym zero :
             *  [['name' => '', 'condition' => "", 'color' => '', 'fill' => '']];
             *
             */
            $conditions = $this->options['conditions'] ??
                [['name' => '', 'condition' => "", 'color' => '', 'fill' => '']];

            foreach ($conditions as $condition) {
                /**
                 * 'top_results'(optional, integer) - limit number of results shown, see Issue #49
                 */

                if (isset($this->options['top_results']) && !is_int($this->options['top_results'])) {
                    throw new \Exception('Top results value should be integer');
                }
                /**
                 * Stowrzenie  obiketu kwerendy do bazy dancyh njpwrd wyniki kweredny sa wlascowsciami tego obiektu
                 * odniesienie sie do nazwy klasy modelu $this->options['model']
                 *
                 * 'filter_field'  - objasnienie(njpwrd filtruj wg daty)- parametr opcjonalny -  https://github.com/LaravelDaily/laravel-charts
                 * (optional) - show only data filtered by that datetime field (see below)
                 * filter field jest nazwa kolumny odnoszacej sie do czasu dtata godzina itp - filtrowanie wg teh  kolukmny
                 * when -  https://laravel.com/docs/9.x/queries
                 * when - przetwarza lub sprawdza istnienie pola w podanej kolumnie
                 * 1 parametr nazwa kolumny
                 * 2 callback (f-a anonim) - przetwarzajaca wszytskie pola
                 */

                $query = $this->options['model']::when(isset($this->options['filter_field']), function ($query) {
                    //jesli istniej opcja - filtruj wg dni
                    if (isset($this->options['filter_days'])) {
                        return $query->where(
                            $this->options['filter_field'],
                            '>=', //filtru wsztskie wartosci wieksze lub rowne wyliczone i sformatowane ponizej
                            //now() - metoda klasy Carbon - obsluga daty czasu , tworzenie aktualnej daty
                            //  subdays - odejmowanie dni
                            //format() - formatowanie dni w polach
                            now()->subDays($this->options['filter_days'])->format($this->options['date_format_filter_days'] ?? 'Y-m-d')
                        );
                    } else {
                        //opcja filtru wg okresu
                        if (isset($this->options['filter_period'])) {

                            //firmatowanie pol wg podanych opcji
                            switch ($this->options['filter_period']) {
                                case 'week':
                                    $start = date('Y-m-d', strtotime('last Monday'));
                                    break;
                                case 'month':
                                    $start = date('Y-m').'-01';
                                    break;
                                case 'year':
                                    $start = date('Y').'-01-01';
                                    break;
                            }
                            //filtruj po sformatowaniu
                            if (isset($start)) {
                                return $query->where($this->options['filter_field'], '>=', $start);
                            }
                        }
                    }
                    //filtrorowanie wynikow wg podanego zasiegu czasowego  od - do
                    if (isset($this->options['range_date_start']) && isset($this->options['range_date_end'])) {
                        return $query->whereBetween(
                            $this->options['filter_field'],
                            [$this->options['range_date_start'], $this->options['range_date_end']]
                        );
                    }
                });
                /**
                 *
                 * koniec tworzenia obiektu $query
                 */

                /**
                 * jesli istniej opcja whre raw- jest to surowe(natywne zapytanie sql)
                 */
                if (isset($this->options['where_raw']) && $this->options['where_raw'] != '') {
                    //https://laravel.com/docs/9.x/queries
                    //whereraw przyjmuje jako arg strng bedacym  natywnym zapytaniem sql
                    $query->whereRaw($this->options['where_raw']);
                }
                //uwtawinie warunkow dal typu  wyktresu liniowego
                if ($this->options['chart_type'] == 'line' && $condition['condition'] != '') {
                    $query->whereRaw($condition['condition']);
                }
                    //obluga opcji -relationship_name (optional, only for group_by_relationship report type)
                // - the name of model's method that contains belongsTo relationship.
                if ($this->options['report_type'] == 'group_by_relationship') {
                    $query->with($this->options['relationship_name']);
                }
                //with_trashed (optional) - includes soft deleted models - njprwd obsluga  tych wartosci ktre zostaly odrzucone przez filtr
                if (isset($this->options['with_trashed']) && $this->options['with_trashed']) {
                    $query->withTrashed();//??
                }
                // njprwd obsluga  tych wartosci ktre zostaly odrzucone przez filtr
                    //https://yajrabox.com/docs/laravel-datatables/6.0/only-trashed
                if (isset($this->options['only_trashed']) && $this->options['only_trashed']) {
                    $query->onlyTrashed();
                }
                //njpwrd okreslenie co ma byc  wykluczone z zasiegi globalnego i jego obsluga
                if (isset($this->options['withoutGlobalScopes']) && $this->options['withoutGlobalScopes']) {
                    $scopesToExclude = is_array($this->options['withoutGlobalScopes'])
                        ? $this->options['withoutGlobalScopes']
                        : null;

                    $collection = $query->withoutGlobalScopes($scopesToExclude)->get();//wykluczony zasieg jako kolejkcja(obiekt)
                } else {
                    $collection = $query->get();
                }
                //jesli typ zglasznia jest rozny od relacyjnych baz danych
                if ($this->options['report_type'] != 'group_by_relationship') {
                    $collection->where($this->options['group_by_field'], '!=', '');// to stworz zapytanie z uwzgledniem kolejkcji
                }
                    //jesli istnieja kolekcje - wykluczone strefy z zasiewgu globalnego
                if (count($collection)) {
                    $data = $collection
                        ->sortBy($this->options['group_by_field'])
                        ->groupBy(function ($entry) {
                            if ($this->options['report_type'] == 'group_by_string') {
                                return $entry->{$this->options['group_by_field']};
                            } else {
                                if ($this->options['report_type'] == 'group_by_relationship') {
                                    if ($entry->{$this->options['relationship_name']}) {
                                        return $entry->{$this->options['relationship_name']}->{$this->options['group_by_field']};
                                    } else {
                                        return '';
                                    }
                                } else {
                                    if ($entry->{$this->options['group_by_field']} instanceof \Carbon\Carbon) {
                                        return $entry->{$this->options['group_by_field']}
                                            ->format($this->options['date_format'] ?? self::GROUP_PERIODS[$this->options['group_by_period']]);
                                    } else {
                                        if ($entry->{$this->options['group_by_field']} && isset($this->options['group_by_field_format'])) {
                                            return \Carbon\Carbon::createFromFormat(
                                                $this->options['group_by_field_format'],
                                                $entry->{$this->options['group_by_field']}
                                            )
                                                ->format($this->options['date_format'] ?? self::GROUP_PERIODS[$this->options['group_by_period']]);
                                        } else {
                                            if ($entry->{$this->options['group_by_field']}) {
                                                return \Carbon\Carbon::createFromFormat(
                                                    'Y-m-d H:i:s',
                                                    $entry->{$this->options['group_by_field']}
                                                )
                                                    ->format($this->options['date_format'] ?? self::GROUP_PERIODS[$this->options['group_by_period']]);
                                            } else {
                                                return '';
                                            }
                                        }
                                    }
                                }
                            }
                        })
                        //https://www.parthpatel.net/laravel-map-method-example/ - obluga kolekcji laravel
                            //https://www.parthpatel.net/laravel-collection-methods-tutorial/
                        ->map(function ($entries) {
                            if (isset($this->options['field_distinct'])) {
                                $entries = $entries->unique($this->options['field_distinct']);
                            }
                            $aggregate = $entries->{$this->options['aggregate_function'] ?? 'count'}($this->options['aggregate_field'] ?? '');
                            if (@$this->options['aggregate_transform']) {
                                $aggregate = $this->options['aggregate_transform']($aggregate);
                            }
                            return $aggregate;
                        })
                        ->when(isset($this->options['top_results']), function ($coll) {
                            return $coll
                                ->sortDesc()
                                //https://www.itsolutionstuff.com/post/laravel-eloquent-take-and-skip-query-exampleexample.html
                                    //take() will help to get data from a database table with a limit.
                                ->take($this->options['top_results'])
                                ->sortKeys();
                        });
                } else {
                    $data = collect([]);
                }


                if (
                    (isset($this->options['date_format']) || isset($this->options['group_by_period'])) &&
                    isset($this->options['filter_days']) &&
                    @$this->options['show_blank_data']
                ) {
                    $newData = collect([]);
                    $format = $this->options['date_format'] ?? self::GROUP_PERIODS[$this->options['group_by_period']];

                    CarbonPeriod::since(now()->subDays($this->options['filter_days']))
                        ->until(now())
                        ->forEach(function (Carbon $date) use ($data, &$newData, $format) {
                            $key = $date->format($format);
                            $newData->put($key, $data[$key] ?? 0);
                        });

                    $data = $newData;
                }

                if (@$this->options['continuous_time']) {
                    $dates = $data->keys();
                    $interval = $this->options['group_by_period'] ?? 'day';
                    $newArr = [];
                    if (!is_null($dates->first()) or !is_null($dates->last())) {
                        if ($dates->first() === $dates->last()) {
                            $firstDate = Carbon::createFromDate(($dates->first()))->addDays(-14);
                            $lastDate = Carbon::createFromDate(($dates->last()))->addDays(14);
                        }

                        $period = CarbonPeriod::since($firstDate ?? $dates->first())->$interval()->until($lastDate ?? $dates->last())
                            ->filter(function (Carbon $date) use ($data, &$newArr) {
                                $key = $date->format($this->options['date_format'] ?? 'Y-m-d');
                                $newArr[$key] = $data[$key] ?? 0;
                            })
                            ->toArray();
                        $data = $newArr;
                    }
                }

                $dataset = [
                    'name' => $this->options['chart_title'], 'color' => $condition['color'],
                    'chart_color' => $this->options['chart_color'] ?? '', 'fill' => $condition['fill'], 'data' => $data
                ];
            }

            return $dataset;
        } catch (\Error $ex) {
            throw new \Exception('Laravel Charts error: '.$ex->getMessage());
        }
    }

    /**
     * @param  array  $options
     * @throws \Exception
     */
    private function validateOptions(array $options)
    {
        $rules = [
            'chart_title' => 'required',
            'report_type' => 'required|in:group_by_date,group_by_string,group_by_relationship',
            'model' => 'required|bail',
            'group_by_field' => 'required|bail',
            'group_by_period' => 'in:day,week,month,year|bail',
            'aggregate_function' => 'in:count,sum,avg|bail',
            'chart_type' => 'required|in:line,bar,pie|bail',
            'filter_days' => 'integer',
            'filter_period' => 'in:week,month,year',
        ];

        $messages = [
            'required' => 'please specify :attribute option',
            'report_type.in' => 'report_type option should contain one of these values - group_by_date/group_by_string',
            'group_by_period.in' => 'group_by option should contain one of these values - day/week/month/year',
            'aggregate_function.in' => 'number_function option should contain one of these values - count/sum/avg',
            'chart_type.in' => 'chart_type option should contain one of these values - line/bar/pie',
            'filter_period.in' => 'filter_period option should contain one of these values - week/month/year',
        ];

        $attributes = [
            'chart_title' => 'chart_title',
            'report_type' => 'report_type',
            'group_by_field' => 'group_by_field',
            'group_by_period' => 'group_by_period',
            'aggregate_function' => 'aggregate_function',
            'chart_type' => 'chart_type',
            'filter_days' => 'filter_days',
            'filter_period' => 'filter_period',
            'field_distinct' => 'field_distinct',
        ];

        $validator = Validator::make($options, $rules, $messages, $attributes);

        if ($validator->fails()) {
            throw new \Exception('Laravel Charts options validator: '.$validator->errors()->first());
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderHtml()
    {
        return view('crm.chart.html', ['options' => $this->options]);//odniesieniesie do widoku html.blade
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderJs()
    {//'datasets' - to wynik metody prepraredata
        return view('crm.chart.javascript', ['options' => $this->options, 'datasets' => $this->datasets]);//odniesienie sie do widoku javascript.blade
    }

    /**
     * @return string
     */
    public function renderChartJsLibrary()
    {
        return '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>';
    }

    /**
     * @return array
     */
    public function getDatasets()
    {
        return $this->datasets;
    }
}
