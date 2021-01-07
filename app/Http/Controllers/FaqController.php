<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FAQ;

class FaqController extends Controller
{
    //to list all faqs
    public function index(){
        $faqs = FAQ::all();
        return view("faq.list")
            ->with(compact("faqs"));
    }


    //Faq create form
    public function create(){
        return view("faq.createForm");
    }

    //Create new Faq instance
    public function store(Request $request){
        $request->validate(["question"=>"required","answer"=>"required"]);

        $faq = FAQ::create($request->all());

        return redirect()->to(route("faq.index"));
    }

    //Show edit form
    public function edit(FAQ $faq){
        return view("faq.edit")
            ->with(compact("faq"));
    }

    //Update FAQ Instance
    public function update(Request $request, FAQ $faq){
        $request->validate(["question"=>"required","answer"=>"required"]);
        $faq->update($request->all());
        return redirect()->to(route("faq.index"));
    }

    //Delete FAQ
    public function destroy(FAQ $faq){
        $faq->delete();
        return redirect()->to(route("faq.index"));
    }
}
