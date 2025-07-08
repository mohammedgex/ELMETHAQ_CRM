<?php

namespace App\Http\Controllers;

use App\Models\bag;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Delegate;
use App\Models\DocumentType;
use App\Models\Evaluation;
use App\Models\FileTitle;
use App\Models\History;
use App\Models\JobTitle;
use App\Models\Payments;
use App\Models\PaymentTitle;
use App\Models\Sponser;
use App\Models\User;
use App\Models\VisaType;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $delegates = Delegate::all();
        $groups = CustomerGroup::all();
        $jobs = JobTitle::all();
        $sponsers = Sponser::all();
        $visas = VisaType::all();
        $customers = Customer::all();
        $bags = bag::all();
        $users = User::all();
        return view('home', [
            'customers' => $customers,
            'visas' => $visas,
            'sponsers' => $sponsers,
            'jobs' => $jobs,
            'groups' => $groups,
            'delegates' => $delegates,
            'users' => $users,
            'bags' => $bags,
        ]);
    }
}
