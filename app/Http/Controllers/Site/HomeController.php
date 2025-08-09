<?php

namespace App\Http\Controllers\Site;

use App\Models\AccountModel;
use App\Models\MealModel;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Models\ContactModel;
use App\Models\DietTypeModel;
use App\Models\FeedbackModel;

class HomeController extends Controller

{
    use AuthorizesRequests, ValidatesRequests;

    public $viewPath = 'site.home.';

    public function index(){
        return view($this->viewPath.'index');
    }
}
