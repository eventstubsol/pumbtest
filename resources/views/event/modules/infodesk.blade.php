<div class="page" id="infodesk">
    <div class="video-container positioned">
        <img class="full-width-videos" src="{{ assetUrl(getField("infodesk")) }}" ></img>
           @foreach(INF0_DESK_AREAS as $area)
                <div
                        title="{{ $area['title'] }}"
                        class="positioned area @if(isset($area['class'])) {{ $area['class'] }} @endif"
                        data-link="{{ $area['link'] }}"
                        style="{{ areaStyles($area["area"]) }}"></div>
            @endforeach
            <div class="positioned _df_button"
                 title="Guide"
                 source="{{ getField("event_guide_link") }}"
                 style="{{ areaStyles([19, 28.7, 8.7, 22]) }}; background: transparent"
            ></div>
            <a class="positioned" data-toggle="modal" data-target="#faqs-modal"
                 title="FAQs"
                 style="{{ areaStyles([19.7,62.8,8.3,21]) }}; background: transparent"
            ></a>
    </div>
</div>
<!-- Resources -->
<div class="modal fade theme-modal" id="faqs-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body faq-items" id="faq-list">
                <div class="mb-3" id="accordion">
                @foreach($FAQs as $id => $faq)
                    <div class="faq-card mb-3">
                        <a class="text-dark" data-toggle="collapse" href="#collapse{{ $faq->id }}" aria-expanded="true">
                            <h5
                                    @if($id == 0)
                                    class="faq-title active"
                                    @else
                                    class="faq-title"
                                    @endif
                                    id="heading{{ $faq->id }}">{{$faq->question}}</h5>
                        </a>
                        <div id="collapse{{ $faq->id }}"
                             @if($id == 0)
                             class="collapse show"
                             @else
                             class="collapse"
                             @endif
                             aria-labelledby="heading{{ $faq->id }}" data-parent="#accordion">
                            <div class="faq-content">{{$faq->answer}}</div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Resources -->
