<div class="mb-3" id="schedule">
    <ul class="nav nav-pills navtab-bg nav-justified" style="margin: 0px -5px;">
        @php
            $lastDate = false;
            $i = 0;
            $dates = [];
            if(isset($schedule["AUDITORIUM"])){
                foreach ($schedule["AUDITORIUM"] as $id => $event){
                    if($lastDate != $event['start_date']['m']){
                         $lastDate = $event['start_date']['m'];
                    }
                    $event['id'] = $id;
                    $dates[$lastDate][] = $event;
                }
            }
        @endphp
        @foreach($dates as $date => $roomEvents)
            @php
                $i++;
            @endphp
            <li class="nav-item">
                <a href="#sch-{{ $i }}" data-toggle="tab"
                                    aria-expanded="{{ $i === 1 ? "true" : "false" }}"
                                    class="nav-link @if($i === 1) active @endif">{{ $date }}</a>
            </li>
        @endforeach
    </ul>
    @php
        $i = 0;
    @endphp
    <div class="tab-content">
        @foreach($dates as $date => $roomEvents)
            @php
                $i++;
            @endphp
            <div class="tab-pane show {{ $i === 1 ? "active" : "" }}" id="sch-{{ $i }}">
            <ul class="list-unstyled timeline-sm">
                @foreach($roomEvents as $event)
                @php
                    $id = $event['id'];
                @endphp
                <li class="timeline-sm-item">
                    <span class="timeline-sm-date">
                        {{ $event['start_date']['dts'] }} - {{ $event['start_date']['dte'] }}
                    </span>
                    <div class="border border-heavy p-2 mb-3 bg-white hover-shadow ">
                        <div class="avatar-group mb-2">
                            @foreach($event['speakers'] as $speaker)
                                <a class="avatar-group-item open-profile-popup"
                                   data-id="{{ $speaker->speaker->id ?? "" }}" data-toggle="tooltip" data-placement="top"
                                   title="{{ isset($speaker->speaker->getFullName) ? $speaker->speaker->getFullName() : "" }}"
                                   data-original-title="{{ isset($speaker->speaker->getFullName) ? $speaker->speaker->getFullName() : "" }}">
                                    <img src="{{ $speaker->speaker->profileImage ?? "" }}"
                                         class="rounded-circle avatar-sm" alt="">
                                </a>
                            @endforeach
                        </div>
                        <h5 class="mt-0 mb-1">{{ $event['name'] }}</h5>
                        <p class="text-dark mt-2">{{ $event['description'] }}</p>
                        @if(isset($subscriptions))
                            <div class="mt-2 border-top d-flex justify-content-between pt-1">
                                    <span>
                                        @if($event['status'] === 1 || $event['status'] === 3)
                                            <a href="javascript: void(0);"
                                               class="btn btn-sm btn-link text-muted font-14 area "
                                               data-link="auditorium">
                                            <i class="mdi mdi-open-in-app mr-1"></i> Visit Auditorium
                                        </a>
                                        @elseif($event['status'] === -1 && $event['recording'])
                                            <a class="video-play btn btn-sm btn-link text-muted font-14 area "
                                               href="{{ $event['recording'] }}">
                                            <i class="mdi mdi-video mr-1"></i> View Recording
                                        </a>
                                        @endif
                                    </span>
                                <span>
                                        @if($event['status'] === 1 || $event['status'] === 3)
                                        <span class="btn btn-sm btn-link text-muted font-14 ">
                                             <i class="mdi mdi-clock mr-1"></i>{{ $event['status'] === 1 ? "Ongoing" : "Starting soon" }}
                                            </span>
                                    @elseif($event['status'] === -1)
                                        <span class="btn btn-sm btn-link text-muted font-14 ">
                                                Session Ended
                                            </span>
                                    @else
                                        <a href="javascript: void(0);" data-id="{{ $id }}"
                                           class="btn subscribe-to-event btn-sm btn-link text-muted font-14 {{ in_array($id, $subscriptions) ? "hidden" : "" }}">
                                                <i class="mdi mdi-bell-ring mr-1"></i> Remind me
                                            </a>
                                        <a href="javascript: void(0);" data-id="{{ $id }}"
                                           class="btn unsubscribe-event btn-sm btn-link text-muted font-14  {{ in_array($id, $subscriptions) ? "" : "hidden" }}">
                                                <i class="mdi mdi-bell-off mr-1"></i> Unsubscribe
                                            </a>
                                    @endif
                                    </span>
                            </div>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
            </div>
        @endforeach
    </div>

</div> <!-- end #accordions-->
