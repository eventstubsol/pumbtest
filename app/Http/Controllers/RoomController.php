<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;


class RoomController extends Controller
{
  //to list all rooms
  public function index(){
      $rooms = Room::orderBy("position")->get();;
      return view("room.list")
          ->with(compact("rooms"));
  }


  //room create form
  public function create(){
      return view("room.createForm");
  }

  //Create new room instance
  public function store(Request $request){
      $request->validate(["name"=>"required","type"=>"required"]);
      $roomsCount = Room::count();
      $room = Room::create([
        "name" => $request->name,
        "type" => $request->type,
        "position"=>$roomsCount,
      ]);
      return redirect()->to(route("room.index"));
  }

  //Show edit form
  public function edit(ROOM $room){
      return view("room.edit")
          ->with(compact("room"));
  }

  //Update room Instance
  public function update(Request $request, ROOM $room){
      $request->validate(["name"=>"required","type"=>"required"]);
      $room->update($request->all());
      return redirect()->to(route("room.index"));
  }

  //Delete room
  public function destroy(ROOM $room){
      $room->delete();
      return redirect()->to(route("room.index"));
  }

  public function sort()
  {
     $rooms = Room::orderBy("position")->get();
      return view("room.sort")
          ->with(compact("rooms"));
  }


  public function storesort(Request $request)
  {
    $array = $request->get("rooms");
    foreach ($array as $position => $room_id) {
      Room::where("id",$room_id)->update(["position" => $position]);
    }
     return [
      "success"=>true
    ];
  }
}
