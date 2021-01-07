@foreach ($rooms as $id => $room)
	<div class="page booths" data-name="{{ $room->name }}" id="room-{{ $room->id }}">
	<div id="roomscarousel" class="carousel slide w-100 h-100" data-ride="carousel">
	  <div class="carousel-inner w-100 h-100">
	  @php
	  	$i = 0;
	  @endphp	    
{{--	@foreach($rooms as $id => $room)--}}
		@if(count($room->booths))
		<div class="carousel-item @if($i==0) active @endif" style="height: 100vh">
		    <img src="{{ assetUrl(getField($room->type)) }}" class="positioned booth-bg" alt="">
		    <h2>{{$room->name}} - Booths</h2>
		    <div class="booths" style="padding: 10%; padding-left: 20%;">
		        @foreach($room->booths as $booth)
			            <div 
			            class="area {{$room->type}}"
			            data-link="booth/{{ $booth->id }}">
			                <p>{{ $booth->name }}</p>
			            </div>
		        @endforeach
		    </div>
		</div>
		@php
			$i++;
		@endphp
		@endif
{{--    @endforeach--}}
	  <a class="carousel-control-prev" href="#roomscarousel" role="button" data-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control-next" href="#roomscarousel" role="button" data-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>
</div>
</div>
@endforeach