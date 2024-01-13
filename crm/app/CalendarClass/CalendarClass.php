<?php

namespace App\CalendarClass;

use App\Models\Crm\Task;

class CalendarClass
{


    public function __construct()
    {

    }

    public function __destruct()
    {

    }


    public function renderJs()
    {//'datasets' - to wynik metody prepraredata

        $taskFields = array();
        $tasks = Task::all();
        foreach ($tasks as $task) {
            $color = null;
            if ($task->title == 'Test') {
                $color = '#924ACE';
            }
            if ($task->title == 'Test 1') {
                $color = '#68B01A';
            }

            $taskFields[] = [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'start' => $task->start_date,
                'end' => $task->end_date,
                'test' => $task->test,
                'color' => $color
            ];
        }
        return view('crm.calendar.javascript', compact('taskFields'));
    }


    public function renderJsLib()
    {
        return view('crm.calendar.javascript-lib');

    }
}
