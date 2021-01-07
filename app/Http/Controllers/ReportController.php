<?php

namespace App\Http\Controllers;

use App\Report;

use App\Resource;

use App\Video;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $reports = Report::all();
        return view("report.list")
            ->with(compact("reports"));
    }


    //Report create form
    public function create(){
        return view("report.createForm");
    }

    //Create new Report instance
    public function store(Request $request){
        $request->validate([          
            "title"=>"required",
           ]);
        $report = Report::create([
            "title"=>$request->title,
        ]);
        if($request->url1){
            Resource::create([
                "booth_id"=>$report->id,
                "title"=>$request->title,
                "url"=>$request->url1,
            ]);
        }
        if($request->url2){
            Resource::create([
                "booth_id"=>$report->id,
                "title"=>$request->title,
                "url"=>$request->url2,
            ]);
        }
        if($request->video){
            Video::create([
                "owner"=>$report->id,
                "title"=>$request->title,
                "url"=>$request->video
            ]);
        }
        return redirect()->to(route("report.index"));
    }

    //Show edit form
    public function edit(Report $report){
        $report->load(["resources","video"]);
        return view("report.edit")
            ->with(compact("report"));
    }

    //Update Report Instance
    public function update(Request $request, Report $report){
        $request->validate([
            "title"=>"required"
        ]);
        $report->update([
            "title"=>$request->title,
        ]);
        $resource = Resource::where([
            "booth_id" => $report->id
        ])->get();
        if(isset($resource[0]) && isset($request->url1) && strlen($request->url1)) {
            $resource[0]->title = $request->title;
            $resource[0]->url = $request->url1;
            $resource[0]->save();
        }
        else if($request->url1 && strlen($request->url1)){
            Resource::create([
                "booth_id"=>$report->id,
                "title"=>$request->title,
                "url"=>$request->url1,
            ]);
        }
        if(isset($resource[1]) && strlen($request->url2)) {
            $resource[1]->title = $request->title;
            $resource[1]->url = $request->url2;
            $resource[1]->save();
        }else if($request->url2 && strlen($request->url2)){
            Resource::create([
                "booth_id"=>$report->id,
                "title"=>$request->title,
                "url"=>$request->url2,
            ]);
        }
        if(isset($request->video)){
            $video = Video::firstOrNew([
                "owner" => $report->id
            ]);

            $video->title = $request->title;
            $video->url = $request->video;
            $video->save();
        }

        return redirect()->to(route("report.index"));
    }

    //Delete Report
    public function destroy(Report $report){
        $report->delete();
        Resource::where("booth_id",$report->id)->delete();
        return redirect()->to(route("report.index"));
    }
}
