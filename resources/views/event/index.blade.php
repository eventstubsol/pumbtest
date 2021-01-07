@php
$user = Auth::user();
@endphp
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ getField("title", "Event") }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css">
    <link href={{ asset("assets/libs/select2/css/select2.min.css" )}} rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset("event-assets/YouTubePopUp/YouTubePopUp.css")}}">
    {{--    App favicon--}}
    <link rel="shortcut icon" href="{{assetUrl(getField("favicon"))}}">
    <!-- Icons -->
    <link href={{asset("assets/css/icons.min.css")}} rel="stylesheet" type="text/css" />
    <script>
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
        if (msie > 0) // If Internet Explorer, return version number
        {
            alert("For an immersive experience on our platform please use some modern browser like Chrome, Safari or Firefox.");
        }
    </script>
    <!-- Onesignal -->
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js"></script>
    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
    <script>
        window.OneSignal = window.OneSignal || [];
       OneSignal.push(function() {
           // Occurs when the user's subscription changes to a new value.
           OneSignal.setExternalUserId("{{ Auth::user()->id }}");
           OneSignal.sendTags({
               "user_type": "{{ $user->type }}",
               "name": "{{ $user->name }}",
           });
           OneSignal.on('subscriptionChange', function (isSubscribed) {
               console.log("Subscription changed", isSubscribed)
               if(isSubscribed){
                   OneSignal.getUserId().then(function(userId) {
                   $.ajax({
                       url: "{{ route('registerDevice') }}",
                       method: "POST",
                       data:{
                           device_id: userId,
                           _token:  "{{ csrf_token() }}",
                       },
                       success: function(response){
                            if(response && response.success){
                                console.log("Device Saved");
                            }else{
                                console.log("Could not save device id.");
                            }
                       },
                       error: function(){
                            console.log("Could not save device id.");
                       },
                   });
                });
               }
           });
           OneSignal.init({
               appId: "{{ env("ONESIGNAL_APP_ID") }}",
               // notifyButton: {
               //     enable: true,
               // },
               allowLocalhostAsSecureOrigin: {{ env("APP_DEBUG", true) ? "true" : "false" }}, //Making it false when the app goes into production
           });
       });
    </script>
    @include("includes.styles.sweetalert2")
    @include("includes.styles.fileUploader")
    <!-- Custom -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link href="{{ asset("/dflip/css/dflip.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("/dflip/css/themify-icons.css") }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset("event-assets/css/app.css") }}">
    <link href="{{asset('assets/css/custom.css')}}?v=364755" rel="stylesheet" type="text/css" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ env("GA_TRACKING_ID") }}"></script>
    @php
    $user = Auth::user();
    @endphp
    <script>
        const GA_MEASUREMENT_ID = '{{ env("GA_TRACKING_ID") }}';
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', GA_MEASUREMENT_ID);
        gtag('set', {'user_id': '{{ $user->id }}'}); // Set the user ID using signed-in user_id.

        function recordEvent(type, event_label, event_category){
            if(typeof event_category === "undefined"){
                event_category = "general"
            }
            gtag('event', type, {
                event_category,
                event_label
            });
        }
        window.recordEvent = recordEvent;
        let lastPage = false;
        let currentPage = false;
        function recordPageView(page_path, page_title = ""){
            if(page_path === "go_back" && lastPage){
                console.log("Going Back")
                page_path = lastPage.page_path;
                page_title = lastPage.page_title;
            }else{
                lastPage = currentPage;
                currentPage = {
                    page_path,
                    page_title,
                };
            }
            gtag('config', GA_MEASUREMENT_ID, {
                page_path,
                page_title
            });
        }
    </script>
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:1993421,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
</head>

<body class="custom-theme">
    <div class="loader"></div>
    @php
    $boothConfig = [];
    /*foreach ($booths as $booth){
    $boothConfig[$booth->id] = $booth->name;
    }
*/
    @endphp

    @include("event.modules.Navbar")
{{--    @include("event.modules.Menubar")--}}
{{--    @include("event.modules.Sidebar")--}}

{{--    @if(isOpenForPublic("photo-booth"))--}}
{{--    @include("event.modules.Booths.PhotoBooth")--}}
{{--    @endif--}}

{{--    @if(isOpenForPublic("library"))--}}
{{--    @include("event.modules.Resources")--}}
{{--    @endif--}}

{{--    @include("event.modules.Exterior")--}}
{{--    @include("event.modules.Lobby")--}}

{{--    @include("event.modules.Booths.BoothList")--}}

{{--    @include("event.modules.Booths.ExpoHall")--}}

{{--    @include("event.modules.Booths.SingleBooth")--}}

{{--    @include("event.modules.Leaderboard")--}}
{{--    @include("event.modules.MuseumList")--}}
{{--    @include("event.modules.MuseumSingle")--}}

{{--    @if(isOpenForPublic("swagbag"))--}}
{{--    @include("event.modules.Report")--}}
{{--    @endif--}}

{{--    @if(isOpenForPublic("meet-and-greet"))--}}
{{--    @include("event.modules.MeetGreet")--}}
{{--    @endif--}}

{{--    @include("event.modules.Faq")--}}

{{--    @if(isOpenForPublic("swagbag"))--}}
{{--    @include("event.modules.Swagbag")--}}
{{--    @endif--}}

{{--    @if(isOpenForPublic("lounge"))--}}
{{--    @include("event.modules.Lounge")--}}
{{--    @endif--}}

{{--    @include("event.modules.SchedulePopup")--}}

{{--    @include("event.modules.Profile")--}}

    @include("event.modules.chat")

{{--    @include("event.modules.Confirmation")--}}

    @include("event.modules.webinar")
{{--    @include("event.modules.workshop")--}}

{{--    @if(isOpenForPublic("caucus"))--}}
{{--    @include("event.modules.caucusRoom")--}}
{{--    @endif--}}

{{--    @include("event.modules.infodesk")--}}

    {{--Information Dialog - for opening of booth rooms at specific timings && also for booth enquiry - DO NOT REMOVE--}}
{{--    @include("event.modules.Information")--}}

{{--    @include("event.modules.Delegates")--}}
{{--    @include("event.modules.ArchiveVideos")--}}

{{--    @include("event.modules.ByLaws")--}}

    <script>
        const config = {
        baseRoute: "{{ url("/") }}",
        leaderboard: "{{ route("leaderboard") }}",
        token: "{{ csrf_token() }}",
        trackEvent: "{{ route("trackEvent") }}",
        getswagBag:"{{ route('getSwagBag') }}",
        addtoBag: "{{ route('addToBag') }}",
        deletefromBag: "{{ route('deleteFromBag') }}",
        boothDetails: "{{ route('boothDetails', ["booth" => "BID"]) }}",
        delegateList: "{{ route("delegateList") }}",
        socketUri: "{{ env('SOCKET_URI') }}",
        userId: "{{ $user->id }}",
        userName: "{{ $user->name }}",
        booths: {!! json_encode($boothConfig) !!},
        saveprofile:"{{ route('saveprofile') }}",
        cometChat: {
            appID: "{{ env("COMET_CHAT_APP_ID") }}",
            region: "{{ env("COMET_CHAT_REGION") }}",
            authKey: "{{ env("COMET_CHAT_AUTH_KEY") }}",
            supportChatUser: "{{ SUPPORT_USER }}",
        },
        candidateBooth: "{{ CANDIDATES_BOOTH_ROOM }}",
        auditoriumEmbed: "{{ route("auditoriumEmbed") }}",
        meetEmbed: "{{ route("meetEmbed") }}",
        checkCurrentSession: "{{ route("currentSession") }}",
        profileImage: "{{ $user->profileImage ? $user->profileImage : "https://ui-avatars.com/api/?name=".urlencode($user->name) }}",
        profile: {!! json_encode(getProfileDetails()) !!},
        profileURL: '{{ route("event.profile") }}',
        profileUpdateURL: '{{ route("updateProfile") }}',
        suggestedContactsURL: '{{ route("suggestedContacts") }}',
        attendeesURL: '{{ route("attendeesURL") }}',
        sendConnectionURL: '{{ route("sendConnectionRequest") }}',
        updateConnectionURL: '{{ route("updateConnectionRequest") }}',
        addToContactURL: '{{ route("addToContacts") }}',
        removeContactURL: '{{ route("removeContact") }}',
        savedContactsURL: '{{ route("savedContacts") }}',
        connectionRequestsURL: '{{ route("myConnectionRequests") }}',
        contentTickerURL: '{{ route("contentTicker") }}',
        tagSuggestions: {!! json_encode(getSuggestedTags()) !!},
        showInterestURL: "{{ route("showInterestInBooth", ["booth" => "BID"]) }}",
        exportContactsURL: "{{ route("exportContacts") }}",
        mailContactsURL: "{{ route("sendContactsOnMail") }}",
        fetchUserDetails: "{{ route("fetchUserDetails") }}",
        subscribeToEvent: "{{ route("event.subscribe", ["event" => "EVENT_ID"]) }}",
        unsubscribeToEvent: "{{ route("event.unsubscribe", ["event" => "EVENT_ID"]) }}",
        byLawsURL: "{{ route('byLaws.get') }}",
        byLawsSubmissionURL: "{{ route('byLaws.submit') }}",
        byLawsOptionSubmissionURL: "{{ route('byLaws.optionSubmit') }}",
    };
    const assetUrl = url => "{{ assetUrl("") }}"+url;
    window.assetUrl = assetUrl;
    window.config = config;
    </script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset("event-assets/js/routie.min.js") }}"></script>
    <script src="{{ asset("event-assets/js/app.js") }}?cb=1"></script>
        <script src="{{ asset("/js/chat/app.js") }}"></script>
{{--    <script src="{{ asset("/js/by-laws/App.js") }}"></script>--}}
    <script src="{{ asset("/js/profile/index.js") }}"></script>
    <script src="{{asset("event-assets/YouTubePopUp/YouTubePopUp.jquery.js")}}"></script>
    <script src="{{asset("event-assets/YouTubePopUp/PopupInit.js")}}"></script>

    <script>
        function oneSignalJsInit(){
        OneSignal.push(function(){
            OneSignal.showNativePrompt();
        });
    }


    function initJs(){
        $('body').addClass('loaded');
        let consent = localStorage.getItem('notifyConsent');
        let consentNotify = $('.consent-notification');

        if(consent === null || consent === 'skip'){
            consentNotify.addClass('enable');
            recordEvent("push_notification_consent", "Push Notifications Consent Box Shown");
        } else if(consent === 'allow') {
            oneSignalJsInit();
        }

        $('.btn[data-consent]').on('click',function(){
            let consent = $(this).data('consent');
            if(consent == "skip"){
                localStorage.setItem('notifyConsent', 'skip');
                recordEvent("push_notification_allow", "Push Notifications Skipped");
            } else if(consent == true){
                localStorage.setItem('notifyConsent', 'allow');
                recordEvent("push_notification_allow", "Push Notifications Allowed");
                oneSignalJsInit();
            } else{
                recordEvent("push_notification_deny", "Push Notifications Denied");
                localStorage.setItem('notifyConsent', 'dontallow');
            }
            consentNotify.removeClass('enable');
        });

        $('#prizes').on('slid.bs.carousel', function () {
            var $parent = $(this).parents('.d-block');
            var $prtext = $parent.find('.pr-text');
            var $cprtext = $(this).find('.active').data('prize-rank');
            $prtext.text($cprtext);
        });

        $('.faq-card .collapse').on('shown.bs.collapse', function () {
            $(this).parents('.faq-card').find('.faq-title').addClass('active');
            $(this).parents('.faq-card').siblings().find('.faq-title').removeClass('active');
            recordEvent("faq_opened", "FAQ Opened");
        });

    }
    $(document).ready(initJs);
    </script>

    <script src="{{ asset("event-assets/js/ResourceInit.js") }}"></script>

    <link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css" />
    <script src="https://unpkg.com/simplebar@latest/dist/simplebar.min.js"></script>

    @include("includes.scripts.fileUploader")
    @include("includes.scripts.sweetalert2")

    {{--Select2 init--}}
    <script src={{ asset("assets/libs/select2/js/select2.min.js" )}}></script>
    <script>
        function initializeSelect(){
        $('[data-toggle="select2"]').select2({
            minimumResultsForSearch: -1
        });
    }
    $(document).ready(initializeSelect);
    const sendBtn = $("#sendEmailBtn");
    sendBtn.click(function(e){
        e.preventDefault()
        sendBtn.text("Sending...");
        $.ajax({
            url: '{{ route("sendSwagsToEmail") }}',
            method: "GET",
            success(r) {
                sendBtn
                    .text("Sent")
                    .removeClass("btn-primary")
                    .addClass("btn-success");

                setTimeout(() => {
                    sendBtn
                        .text("Mail Me")
                        .addClass("btn-primary")
                        .removeClass("btn-success");
                }, 2000);
            }
        })
    })
    </script>
    <script src="{{ asset("dflip/js/dflip.min.js") }}" type="text/javascript"></script>
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.slim.js"></script>--}}
    <script async src="https://app.popkit.club/pixel/3c26bfdb333b6fecd7284b84b0465334"></script>
</body>

</html>