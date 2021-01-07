<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        $user = Auth::user();
        if(!$user){
            return redirect(route('attendee_login'));
            return view("landing");
        }
        if(view()->exists("dashboard.".$user->type)){
            return redirect("/home");
        }
        return redirect('event');
    }

    public function dashboard(){
        $user = Auth::user();
        if(view()->exists("dashboard.".$user->type)){
            return view("dashboard.".$user->type);
        }
        return redirect('event');
    }

    public function faqs(){
        $FAQs = \App\FAQ::all();
        return view("event.faq")->with(compact("FAQs"));
    }

    public function privacyPolicy(){
        return view("event.tos");
    }
}
