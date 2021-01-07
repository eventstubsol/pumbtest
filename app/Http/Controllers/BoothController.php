<?php

namespace App\Http\Controllers;

use App\BoothInterest;
use Illuminate\Http\Request;

use App\Booth;

use App\Room;

use App\User;

use App\BoothAdmin;

use App\Image;

use App\Video;

use App\Resource;
use Illuminate\Support\Facades\Http;

class BoothController extends Controller
{
  public function index()
  {
    $booths = Booth::with(["room", "admins"])->get(["id", "name", "url","type","boothurl"]);
    return view("booth.list")
      ->with(compact(["booths"]));
  }


  //booth create form
  public function create()
  {
    $rooms = Room::all()->load("booths");
    $users = User::where("type", "exhibiter")->get();
    return view("booth.createForm")
      ->with(compact(["rooms", "users"]));
  }

  //Create new booth instance
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'type' => 'required',
      'room_id' => 'required',
      'userids' => 'required',
    ]);
    $booth = new Booth([
      "name" => $request->get("name"),
      "room_id" => $request->get("room_id"),
      "type" => $request->get("type"),
       "calendly_link"=>$request->get("calendly_link"),
    ]);
    $booth->save();

    // create group in comet chat
    Http::withHeaders([
      "apiKey" => env("COMET_CHAT_API_KEY"),
      "appId" => env("COMET_CHAT_APP_ID")
    ])
      ->post(env('COMET_CHAT_BASE_URL') . "/v2.0/groups", [
        "type" => strtolower(env("COMET_CHAT_GROUP_TYPE")),
        "guid" => $booth->id,
        "name" => $booth->name
      ]);

    $user_ids = $request->get("userids");
    foreach ($user_ids as $user_id) {
      BoothAdmin::create([
        "user_id" => $user_id,
        "booth_id" => $booth->id,
      ]);
    }

    // create group admin
    Http::withHeaders([
      "apiKey" => env("COMET_CHAT_API_KEY"),
      "appId" => env("COMET_CHAT_APP_ID")
    ])
      ->post(env('COMET_CHAT_BASE_URL') . "/v2.0/groups/" . $booth->id . "/members", ["admins" => $user_ids]);
    return redirect()->to(route("booth.index"));
  }

  //Show edit form
  public function edit(Booth $booth)
  {
    $rooms = Room::all();
    $booth->load(["admins", "room"]);
    $users = User::where("type", "exhibiter")->get();
    return view("booth.edit")
      ->with(compact(["booth", "rooms", "users"]));
  }

  //Update booth Instance
  public function update(Request $request, Booth $booth){
      $request->validate(['name' => 'required',
            'type' => 'required',
            'room_id' => 'required',
            'userids' => 'required',
        ]);
      $booth->update([
        "name" => $request->get("name"),
        "room_id" => $request->get("room_id"),
        "type"=> $request->get("type"),
        "boothurl"=>$request->get("boothurl"),
        "calendly_link"=>$request->get("calendly_link"),
      ]);

      // update group
      Http::withHeaders([
          "apiKey" => env("COMET_CHAT_API_KEY"),
          "appId" => env("COMET_CHAT_APP_ID")
      ])
          ->put(env('COMET_CHAT_BASE_URL') . "/v2.0/groups/" . $booth->id, ["name" => $request->get("name")]);

      //update users
      BoothAdmin::where("booth_id",$booth->id)->delete();
      $user_ids = $request->get("userids");
      foreach ($user_ids as $user_id) {
        $boothadmin = BoothAdmin::create([
          "user_id" => $user_id,
          "booth_id" => $booth->id,
        ]);
      }
      // getting all group users
//      $response = Http::withHeaders([
//          "apiKey" => env("COMET_CHAT_API_KEY"),
//          "appId" => env("COMET_CHAT_APP_ID")
//      ])->get(env('COMET_CHAT_BASE_URL') . "/v2.0/groups/" . $booth->id . "/members");

//      $oldAdmins = array_map(function ($v) {
//          return $v["uid"];
//      }, $response["data"]);

      // kick old admins
//      foreach ($oldAdmins as $admin) {
//          Http::withHeaders([
//              "apiKey" => env("COMET_CHAT_API_KEY"),
//              "appId" => env("COMET_CHAT_APP_ID")
//          ])->delete(env('COMET_CHAT_BASE_URL') . "/v2.0/groups/" . $booth->id . "/members/" . $admin);
//      }

//    $oldAdmins = array_map(function ($v) {
//      return $v["uid"];
//    }, $response["data"]);
//
    // kick old admins
//    foreach ($oldAdmins as $admin) {
//      Http::withHeaders([
//        "apiKey" => env("COMET_CHAT_API_KEY"),
//        "appId" => env("COMET_CHAT_APP_ID")
//      ])->delete(env('COMET_CHAT_BASE_URL') . "/v2.0/groups/" . $booth->id . "/members/" . $admin);
//    }

    // add new admins
//    Http::withHeaders([
//      "apiKey" => env("COMET_CHAT_API_KEY"),
//      "appId" => env("COMET_CHAT_APP_ID")
//    ])
//      ->post(env('COMET_CHAT_BASE_URL') . "/v2.0/groups/" . $booth->id . "/members", ["admins" => $user_ids]);

    return redirect()->to(route("booth.index"));
  }

  //Delete booth
  public function destroy(Booth $booth)
  {
    Http::withHeaders([
      "apiKey" => env("COMET_CHAT_API_KEY"),
      "appId" => env("COMET_CHAT_APP_ID")
    ])
      ->delete(env('COMET_CHAT_BASE_URL') . "/v2.0/groups/" . $booth->id);

    $booth->delete();
    return redirect()->to(route("booth.index"));
  }

  public function adminEdit(Request $req, Booth $booth)
  {
      $booth->load(["images", "videos", "resources"]);
    return view("exhibitor.edit")->with(compact("booth"));
  }

  public function adminUpdate(Request $request, Booth $booth)
  {
    $booth->load(["images", "videos", "resources"]);
    //upload images
    Image::where("owner", $booth->id)->delete();
    $boothlinks = $request->boothlinks;
    foreach ($request->boothimages as $id => $boothimage) {
      if (!empty(trim($boothimage))) {
        $booth->images()->create([
          "title" => "Slot " . $id,
          "url" => $boothimage,
          "link" =>  $boothlinks[$id],
        ]);
      }
    }
    if ($request->has("corouselimages")) {
      $link = $request->corousellink ? $request->corousellink : "";
      foreach ($request->corouselimages as $image) {
        if (!empty(trim($image))) {
          $booth->images()->create([
            "url" => $image,
            "link" => $link,
            "title" => "corousel"
          ]);
        }
      }
    }

    //uploading videos
    Video::where("owner", $booth->id)->delete();
    if ($request->has("boothvideos")  && is_array($request->boothvideos)) {
      foreach ($request->boothvideos as $id => $boothvideo) {
        if (!empty(trim($boothvideo))) {
          $booth->videos()->create([
            "url" => $boothvideo,
            "title" => $request->videotitles[$id],
          ]);
        }
      }
    }
    if ($request->has("brandvideos") && is_array($request->brandvideos)) {
      foreach ($request->brandvideos as $i => $brandvideo) {
        if (!empty(trim($brandvideo))) {
          $booth->videos()->create([
            "url" => $brandvideo,
            "title" => "brandvideo",
            "thumbnail" => $request->brandvideothumbnails[$i],
          ]);
        }
      }
    }

    //updating resources

    $requesturls = $request->resources; //Recieved from form
    $deletedResources = [];
    if(!$requesturls || !is_array($requesturls)){
        $requesturls = [];
    }
    $oldResources = Resource::where("booth_id", $booth->id)->get();
    $oldResourceurls = []; //From database
    foreach ($oldResources as $id => $resource) {
      if (!in_array($resource->url, $requesturls)) {
        $resource->swagbag()->delete();
        $resource->delete();
        array_push($deletedResources, $resource->url);
      } else {
        array_push($oldResourceurls, $resource->url);
      }
    }
    if ($requesturls) {
      foreach ($requesturls as $id => $requrl) {
        if (!in_array($requrl, $oldResourceurls)) {
          if (!empty(trim($requrl))) {
            Resource::create([
              "booth_id" => $booth->id,
              "url" => $requrl,
              "title" => $request->resourcetitles[$id],
            ]);
          }
        } elseif (!in_array($requrl, $deletedResources)) {
          $resource = Resource::where("url", $requrl)->update(["title" => $request->resourcetitles[$id]]);
        }
      }
    }
    //booth description update
    $booth->update([
      "description" => $request->description,
      "url" => $request->url,   //Booth Website
    ]);

      $booth->load(["images", "videos", "resources"]);

    return redirect()->to(route("exhibiter.update", ["booth" => $booth->id]));
  }

  public function boothEnquiries(Booth $booth){
      $booth->load("interests.user");
//      return $booth;
      return view("exhibitor.enquiries")->with(compact("booth"));
  }

  public function publish(Booth $booth){
      $booth->publish();
      return ['success' => true];
  }

  public function unpublish(Booth $booth){
      $booth->unpublish();
      return ['success' => true];
  }
}
