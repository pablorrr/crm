<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyFormRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Crm\Company;
use App\Models\Team;
use App\Traits\CheckApprenticeTrait;
use App\Traits\getValidatorTrait;
use Illuminate\Http\Request;


class CompanyController extends Controller
{
    use getValidatorTrait, CheckApprenticeTrait;

    protected $validator;

    public function __construct()
    {
        $this->validator = $this->getCompanyValidator(new CompanyFormRequest());
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function index()
    {
        $companies = Company::all();
        $menuVar = ['Kalendarz', 'Dodaj osobe', 'Dodaj Firme'];
        return view('crm.company', compact('companies', 'menuVar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        //abort access to apprentice, resource not allowed to use middelware(no perticular path)!!!
        /**
         * Uwaga!!! przy testowaniu dostepu do danej akcji rout'a nalezy sparawdzic czy zalogowany user jest w skladzie aktualnego team'u!!!
         *
         */
        $this->checkApprentice($request);

        $validator = $this->validator;
        $menuVar = ['Kalendarz', 'Dodaj osobe', 'Dodaj Firme'];

        return view('crm.form.add-company', compact('validator', 'menuVar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyFormRequest $request)
    {

        $company = new Company();
        $company->name = $request['name'];
        $company->email = $request['email'];
        $company->phone = $request['phone'];

        $company->save();
        // $person::create($request->all());- nie uzywaj tej metody zle obrazki sie wczytuja


        //  Mail::to($request->user())->send(new SendMailable($article));

        return redirect()->route('companies.index')->with([
            'status' => [
                'type' => 'success',
                'content' => 'Firma została dodana',
            ]
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Crm\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crm\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $company_id)
    {
        //abort access to apprentice, resource not allowed to use middelware(no perticular path)!!!
        /**
         * Uwaga!!! przy testowaniu dostepu do danej akcji rout'a nalezy sparawdzic czy zalogowany user jest w skladzie aktualnego team'u!!!
         *
         */
        $this->checkApprentice($request);

        $company = Company::findOrFail($company_id);
        $validator = $this->validator;
        $menuVar = ['Kalendarz', 'Dodaj osobe', 'Dodaj Firme'];

        return view('crm.form.edit-company', compact('company', 'validator', 'menuVar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Crm\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update($company_id, CompanyUpdateRequest $request)
    {
        //abort access to apprentice, resource not allowed to use middelware(no perticular path)!!!
        /**
         * Uwaga!!! przy testowaniu dostepu do danej akcji rout'a nalezy sparawdzic czy zalogowany user jest w skladzie aktualnego team'u!!!
         *
         */
        $this->checkApprentice($request);

        $company = Company::findOrFail($company_id);
        $this->saveCompany($request, $company);


        return redirect()->route('companies.index')->with([
            'status' => [
                'type' => 'success',
                'content' => 'Zapisano zmiany',
            ]
        ]);
    }

    /**
     * @param $request
     * @param $company
     * @return void
     */
    public function saveCompany($request, Company $company): void
    {
        $company->name = $request['name'];
        $company->email = $request['email'];
        $company->phone = $request['phone'];
        $company->save();

    }

    /**
     * Remove companies with checkbox
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCompanies(Request $request)
    {
        $ids = $request->input('ids');

        if ($ids) {

            Company::whereIn('id', $ids)->delete();

            return back()->with([
                'status' => [
                    'type' => 'success',
                    'content' => 'Firma została usunieta',
                ]
            ]);

        } else {
            return back()->with([
                'status' => [
                    'type' => 'danger',
                    'content' => 'Nie wybrałeś żadnej Firmy do usunięcia !!!',
                ]
            ]);
        }
    }
}
