<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonFormRequest;
use App\Http\Requests\PersonUpdateRequest;
use App\Jobs\SendEmailJob;
use App\Mail\SendCreatePersonEmail;

use App\Models\Crm\Person;
use App\Models\Team;
use App\Models\User;
use App\Traits\CheckApprenticeTrait;
use App\Traits\getValidatorTrait;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class PersonController extends Controller
{

    use getValidatorTrait, CheckApprenticeTrait;

    protected $validator;


    public function __construct()
    {
        $this->validator = $this->getPersonValidator(new PersonFormRequest());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {   //https://laravel.com/docs/9.x/eloquent-relationships#eager-loading
       // $persons = Person::all();//lazy loading renderuje wiecej zapytan typu select do db
        $persons = Person::with('user')->get();//eager loading rendewruje dwa zapytania do db dzila szybciej musi byc relacja
        $menuVar = ['Kalendarz', 'Dodaj osobe', 'Dodaj Firme'];


        return view('crm.person', compact('persons', 'menuVar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        //abort access to apprentice, resource not allowed to use middelware(no perticular path)!!!
     //   $this->checkApprentice($request);

        $validator = $this->validator;
        $menuVar = ['Kalendarz', 'Dodaj osobe', 'Dodaj Firme'];

        return view('crm.form.add-person', compact('validator', 'menuVar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(PersonFormRequest $request)
    {
        // lara 8 https://github.com/mohsenkarimi-mk/Laravel-CRUD-With-Multiple-Image-Upload/blob/master/app/Http/Controllers/PostController.php
        //abort access to apprentice, resource not allowed to use middelware(no perticular path)!!!
      //  $this->checkApprentice($request);


      $this->checkApprentice($request);

      $person = new Person();


      $this->savePerson($request, $person);//todo DI

      if ($request->hasFile('photo')) {

       $file = $request->file('photo');
       $imageName = $file->getClientOriginalName();

       $this->savePersonPhoto($person, $imageName,  $file);

      }

      return redirect()->route('persons.index')->with([
            'status' => [
                'type' => 'success',
                'content' => 'Osoba została dodana',
            ]
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crm\Person  $person
     * @return \Illuminate\Http\Response
     */


    public function edit(Request $request, $person_id)
    {
        //abort access to apprentice, resource not allowed to use middelware(no perticular path)!!!
        $this->checkApprentice($request);

        //pobranie z DB
        $person = Person::findOrFail($person_id);
        $validator = $this->validator;
        $menuVar = ['Kalendarz', 'Dodaj osobe', 'Dodaj Firme'];

        return view('crm.form.edit-person', compact('person', 'validator', 'menuVar'));
    }


    public function update($person_id, PersonUpdateRequest $request)
    {
        //abort access to apprentice, resource not allowed to use middelware(no perticular path)!!!
        $this->checkApprentice($request);

        $person = Person::findOrFail($person_id);


        $this->savePerson($request, $person);

        if ($request->hasFile('photo')) {

         $file = $request->file('photo');
         $imageName = $file->getClientOriginalName();

         $this->savePersonPhoto($person, $imageName,  $file);

        }
       return redirect()->route('persons.index')->with([
            'status' => [
                'type' => 'success',
                'content' => 'Zapisano zmiany',
            ]
        ]);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * remove for person blade (checkbox groups)
     */


    public function deletePersons(Request $request)
    {
        /**
         * uwaga w razie problemow z usuwaniem stosuj
         * usuwanie middelware z routingu przy delete
         * php  artisan optimize
         */
        $ids = $request->input('ids');

        if ($ids) {

            //delete from folder
            $persons = Person::select('photo')->whereIn('id', $ids)->get();
            //transform into array
            $personsArr = json_decode(json_encode($persons), true);
            foreach ($personsArr as $photo) {
                File::delete(\public_path('photo/').$photo['photo']);
            }
            //end delete from folder

            //delete from db
            Person::whereIn('id', $ids)->delete();

            return back()->with([
                'status' => [
                    'type' => 'success',
                    'content' => 'Osoba została usunieta',
                ]
            ]);

        } else {
            return back()->with([
                'status' => [
                    'type' => 'danger',
                    'content' => 'Nie wybrałeś żadnej Osoby do usunięcia !!!',
                ]
            ]);
        }
    }


    /**
     * @param  $request
     * @param $person
     * @param $imageName
     * @param $file
     * @return void
     */
    public function savePerson($request,Person $person): void
    //public function savePerson(PersonUpdateRequest $request,Person $person): void
    {
        //abort access to apprentice, resource not allowed to use middelware(no perticular path)!!!
    //    $this->checkApprentice($request);

        $person->name = $request['name'];
        $person->surname = $request['surname'];
        $person->email = $request['email'];
        $person->phone = $request['phone'];

        $person->save();
        // $person::create($request->all());- nie uzywaj tej metody zle obrazki sie wczytuja

    }

    public function savePersonPhoto(Person $person, string $imageName, $file): void

    {
        $person->photo = $imageName;
        $person->save();
        // $person::create($request->all());- nie uzywaj tej metody zle obrazki sie wczytuja
       // $file->move(__DIR__.'/../../../../crm-pbl/photo/', $imageName);
        $file->move(app()->basePath().'/../crm-pbl/photo/', $imageName);

    }
}


