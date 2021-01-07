<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\ProvisionalGroup;
use App\Video;

class ProvisionalController extends Controller
{
    public function index(){
        $provisionals = ProvisionalGroup::all();
        return view("provisionals.list")
            ->with(compact("provisionals"));
    }


    //provisional create form
    public function create(){
        return view("provisionals.createForm");
    }

    //Create new provisional instance
    public function store(Request $request){
        $request->validate(["title"=>"required"]);
        $provisionals = ProvisionalGroup::create([
            "title"=>$request->title,
        ]);
        if(isset($request->url1) && strlen($request->url1)){
            Resource::create([
                "booth_id"=>$provisionals->id,
                "title"=>$request->title,
                "url"=>$request->url1,
            ]);
        }
        if(isset($request->url2)&& strlen($request->url2)){
            Resource::create([
                "booth_id"=>$provisionals->id,
                "title"=>$request->title,
                "url"=>$request->url2,
            ]);
        }
        if(strlen($request->video))
            {
            Video::create([
                "owner"=>$provisionals->id,
                "title"=>$request->title,
                "url"=>$request->video,
            ]);
        }
        return redirect()->to(route("provisional.index"));
    }

    //Show edit form
    public function edit(ProvisionalGroup $provisional){
        $provisional->load(["resource","video"]);
        return view("provisionals.edit")
            ->with(compact("provisional"));
    }

    //Update provisional Instance
    public function update(Request $request, ProvisionalGroup $provisional){
        $request->validate(["title"=>"required"]);
        $provisional->update([
            "title"=>$request->title,
        ]);
        $resource = Resource::where([
            "booth_id" => $provisional->id
        ])->get();
        if(isset($resource[0]) && isset($request->url1) && strlen($request->url1)) {
            $resource[0]->title = $request->title;
            $resource[0]->url = $request->url1;
            $resource[0]->save();
        }
        else if($request->url1 && strlen($request->url1)){
            Resource::create([
                "booth_id"=>$provisional->id,
                "title"=>$request->title,
                "url"=>$request->url1,
            ]);
        }
        if(isset($resource[1]) && isset($request->url2) && strlen($request->url2)) {
            $resource[1]->title = $request->title;
            $resource[1]->url = $request->url2;
            $resource[1]->save();
        }else if($request->url2 && strlen($request->url2)){
            Resource::create([
                "booth_id"=>$provisional->id,
                "title"=>$request->title,
                "url"=>$request->url2,
            ]);
        }
        if(strlen($request->video))
        {
            $video = Video::firstOrNew([
                "owner" => $provisional->id
            ]);
            $video->title = $request->title;
            $video->url = $request->video;
            $video->save();
        }
        return redirect()->to(route("provisional.index"));
    }

    //Delete provisional
    public function destroy(ProvisionalGroup $provisional){
        $provisional->delete();
        Resource::where("booth_id",$provisional->id)->delete();
        return redirect()->to(route("provisional.index"));
    }
}
