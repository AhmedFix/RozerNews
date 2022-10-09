<?php


namespace App\Http\Controllers;

use App\Models\Articale;
use App\Models\Attendance;
use App\Models\Category;
use App\Models\Course;
use App\Models\PushNotification;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    } // end of __construct

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $categories = Category::latest()->get();
        $articales = Articale::latest()->get();
        $users = User::latest()->get();
        $notifications = PushNotification::latest()->get();


        if ($user->hasRole('admin|super_admin')) {
            return view('home', compact('categories', 'articales','users','notifications'));
        } elseif ($user->hasRole('user')) {
            return view('frontend.home', compact('categories', 'articales',));
        } else {
            return 'NO ROLE ASSIGNED YET!';
        }
    }

}
