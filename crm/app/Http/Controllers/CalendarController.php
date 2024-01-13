<?php

namespace App\Http\Controllers;

use App\CalendarClass\CalendarClass;
use App\Mail\SendEmail;
//use App\Mail\SendTaskEmail;
use App\Models\Crm\Person;
use App\Models\Crm\Task;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function MongoDB\BSON\toJSON;


class CalendarController extends Controller
{
    public function index()
    {
        $calendar = new CalendarClass();
        return view('crm.calendar.index', compact('calendar',));
    }


    //below only for testing purposers
    public function indexpdf()
    {
        $tasks = Task::all();
        return view('crm.calendar.tasks-pdf', compact('tasks'));
    }


    public function printPDF()
    {
        $tasks = Task::all();
        $pdf = PDF::loadView('crm.calendar.tasks-pdf', compact('tasks'));
        return $pdf->download('tasks.pdf');
    }


    /**
     * create and store
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'unique:tasks|regex:/^[a-zA-Z ]+$/|max:15',//regex to string pattern, 'string' not enough
            'description' => 'required|regex:/^[a-zA-Z ]+$/|max:32',
            // 'test' => 'regex:/^[a-zA-Z ]+$/|max:32',
            'test' => 'max:32',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'test' => $request->test,
        ]);

        $color = null;

        if ($task->title == 'Test') {
            $color = '#924ACE';
        }

        return response()->json([
            'id' => $task->id,
            'start' => $task->start_date,
            'end' => $task->end_date,
            'title' => $task->title,
            'description' => $task->description,
            'test' => $task->test,
            'color' => $color ? $color : '',

        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * edit and update
     */
    public function edit($id)
    {

        $task = Task::findOrFail($id);
        $users = User::all();
        $menuVar = ['Kalendarz', 'Dodaj osobe', 'Dodaj Firme'];

        return view('crm.form.edit-task', compact('task', 'users', 'menuVar'));
    }


    public function update(Request $request, $id)
    {   //calendar page part
//todo:odblokuj na koniec!!!!
        /*   $request->validate([
               'title' => 'required|regex:/^[a-zA-Z ]+$/|max:16',//regex to string pattern, 'string' not enough
               'description' => 'required|regex:/^[a-zA-Z ]+$/|max:32',
               'start_date' => 'required|date_format:Y-m-d H:i:s',
               'end_date' => 'required|date_format:Y-m-d H:i:s|after:start_date',
               'test' => 'regex:/^[a-zA-Z ]+$/|max:32',
               'user_id' => 'required|integer|max:32',
           ]);*/
//for only testing purposes
        $request->validate([
            'title' => 'max:16',//regex to string pattern, 'string' not enough
            'description' => 'max:32',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date_format:Y-m-d H:i:s|after:start_date',
            'test' => 'regex:/^[a-zA-Z ]+$/|max:32',
            'user_id' => 'required|integer|max:32',
        ]);

        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'error' => 'Unable to locate the task'
            ], 404);
        }
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'test' => $request->test,
        ]);

        $task->user_id = $request->input('user_id');
        $task->save();

        //nie dziala przy update, dzila tylko przy tworzeniu nowych zadan
        //  $task_to_email = Task::where('user_id', $task->user_id)->get()->last(); - mozliwosc odczytu $task_to_email->title

        //user do ktorego ma byc przeslany email
        $user = User::find($task->user_id);

       // Mail::to($user)->send(new SendTaskEmail($request));


        return redirect()->route('calendar.tasks-table')->with([
            'status' => [
                'type' => 'success',
                'content' => 'Zmiany zostały zapisane',
            ]
        ]);
    }

    //end edit and update

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function tasksTable()
    {
        $tasks = Task::all();
        $menuVar = ['Kalendarz', 'Dodaj osobe', 'Dodaj Firme'];
        return view('crm.calendar.tasks', compact('tasks', 'menuVar'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * for event.blade
     */
    public function delete($id)
    {
        $task = Task::all()->find($id);

        $task->delete();

        return redirect()->route('calendar.tasks-table')->with([
            'status' => [
                'type' => 'success',
                'content' => 'Zdarzenie zostało usunięte',
            ]
        ]);
    }

    //for events.blade
    public function destroy(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids) {
            Task::whereIn('id', $ids)->delete();

            return back()->with([
                'status' => [
                    'type' => 'success',
                    'content' => 'Zadanie zostało usunięte',
                ]
            ]);
        } else {
            return back()->with([
                'status' => [
                    'type' => 'danger',
                    'content' => 'Nie wybrałeś żadnego zadania do usunięcia !!!',
                ]
            ]);
        }


    }

    public function show($task_id)
    {
        $task = Task::findOrFail($task_id);
        $menuVar = ['Kalendarz', 'Dodaj osobe', 'Dodaj Firme'];
        return view('crm.calendar.task', compact('task', 'menuVar'));
    }

}
