let loader = $(".loader");
function initApp(){

    //Wait for video load and then hide loader
    loader = $(".loader");
    let exteriorView = $("#exterior_view");
    let enteringView = $("#entering_view");
    let pages = $(".page");
    let navs = $('.navs,.hide-on-exterior');
    let currentresbtns = null;
    //Wait for all three main video loads before removing loader
    waitForVideosLoad(exteriorView, enteringView)
        .then(() => loader.fadeOut());

    //initMenu();
    initSideMenu();

    //Support chat opening
    $(".open-support-chat").on("click", function(e){

        e.preventDefault();
        openChat(config.cometChat.supportChatUser);
        loader.show();
        setTimeout(() => {
            $("body").addClass("right-bar-enabled");
            loader.hide();
        }, 750);
    });

    //Listen for PDF Views and give points for them
    $("body").on("click", function(e){
        let target = $(e.target);
        if(target.hasClass("_df_button")){
            const url = target.attr("source");
            if(url){
                trackEvent({
                    type: "resourceView",
                    url,
                });
            }
        }
    });

    let directAccess = true;
    let areas = $(".area");
    const doNotRoute = [
        "support"
    ];
    areas.on("click", function(e){
        const link = $(this).data("link");
        directAccess = false;
        if(!doNotRoute.includes(link)){
            routie(link);
        }else{
            e.preventDefault();
        }
    });

    $(".subscribe-to-event").on("click", function(e){
        e.preventDefault();
        let t = $(this);
        t.prop("disabled", true);
        if(t.data("id")){
            $.ajax({
                url: window.config.subscribeToEvent.replace("EVENT_ID", t.data("id")),
                method: "POST",
                data: {
                    _token: window.config.token,
                },
                success: function(){
                    showMessage("Subscribed to session. You will now get a priority notification few minutes prior to session.", "success");
                    t.parent().find("a").prop("disabled", false).hide().filter(".unsubscribe-event").show();
                },
                error: function(){
                    showMessage("Error occurred while subscribing to session. Please try again later or refresh page.", "error");
                }
            })
        }
    });
    $(".unsubscribe-event").on("click", function(e){
        e.preventDefault();
        let t = $(this);
        t.prop("disabled", true);
        if(t.data("id")){
            $.ajax({
                url: window.config.unsubscribeToEvent.replace("EVENT_ID", t.data("id")),
                method: "POST",
                data: {
                    _token: window.config.token,
                },
                success: function(){
                    t.parent().find("a").prop("disabled", false).hide().filter(".subscribe-to-event").show();
                },
                error: function(){
                    showMessage("Error occurred while disabling session notification. Please try again later or refresh page.", "error");
                }
            })
        }
    });

    let boothMenus = $(".booth-menu");
    let notboothMenus = $(".not-booth-menu");
    let notboothmenubutton = $("#notbooth_menu_toggle");
    notboothmenubutton.on("click",toggleboothmenu);
    function toggleboothmenu(){
        if(notboothMenus.is(":hidden")){
            notboothMenus.show();
            $("#notbooth_menu_toggle i").removeClass("mdi-chevron-left-circle");
            $("#notbooth_menu_toggle i").addClass("mdi-chevron-right-circle");
            boothMenus.addClass("hidden");
            $(".booth_description").parent().hide();
            $(".booth_resources").parent().hide();
            $(".candidatemenus").hide();
        }else{
            notboothMenus.hide();
            $("#notbooth_menu_toggle i").addClass("mdi-chevron-left-circle");
            $("#notbooth_menu_toggle i").removeClass("mdi-chevron-right-circle");
            boothMenus.removeClass("hidden");
            if(currentresbtns){
                currentresbtns.show();
            }else{
                $(".booth_description").parent().show();
                $(".booth_resources").parent().show();
            }
        }
    }
    window.addEventListener("hashchange", function(e){
        $("#chat-container").removeClass("in-lounge");
        $("body").removeClass("in-lounge");
        $(".candidatemenus").hide();
        $(".booth_description").parent().hide();
        $(".booth_resources").parent().hide();
        let newHash = e.newURL.split("#")[1];
        boothMenus.addClass("hidden");
        notboothmenubutton.addClass("hidden");
        notboothMenus.show();
        if(newHash === "lounge"){
            $("#chat-container").addClass("in-lounge");
            $("body").addClass("in-lounge");
        }
    });

    //Open by-laws modal
    $('a[href="#by-laws"]').on("click", function(e){
        e.preventDefault();
        $("#bylaws-modal").modal();
    });

    //Open Pre-recorded Sessions
    $(".open-session").on("click", function(e){
        e.preventDefault();
        let id = $(this).data("id");
        $("#audi-content").empty().append(`<iframe frameborder="0"  class="positioned fill" src="${window.config.auditoriumEmbed}?type=pre-recorded&id=${id}"></iframe>`);
    });

    $(".open-profile-popup").on("click", function(e){
        e.preventDefault();
        let id = $(this).data("id");
        if(id){
            window.showProfile(id);
        }
    });

    pages.hide();
    $("#audi-content").empty();
    const notFoundRoute = "auditorium";
    //Routing setup
    navs.removeClass('hidden');
    let contentTicker = false;
    let initializedLeaderboard = false;

    function clearContentTicker(){
        if(contentTicker !== false){
            clearInterval(contentTicker);
        }
    }

    function pageChangeActions(){
        currentresbtns = null;
        // window.$socket.emit("update_page", window.location.hash.substr(1));
        loader.hide();
        $("#audi-content").empty();
        $("#caucus-room-content").empty();
        $("#workshop-content").empty();
        navs.removeClass('hidden');
        clearContentTicker();
        $("#audi-modal").modal("hide");
        $("#caucus-modal").modal("hide");
        $("#workshop-modal").modal("hide");
        $("body").removeClass("right-bar-enabled"); //Hide Chat modal
        $("#chat-toggle").show();
        window.scrollTo(0, 0);
        $('.YouTubePopUp-Wrap, .YouTubePopUp-Close').click();
        if($('.page:visible').hasClass('menu-filled')){
            $('.navbar-custom.theme-nav').addClass('filled')
        } else{
            $('.navbar-custom.theme-nav').removeClass('filled')
        }
        if(typeof dfLightBox !== "undefined" && dfLightBox && dfLightBox.closeButton){
            $(dfLightBox.closeButton).trigger("click");
        }
        $('.modal').modal('hide');
    }

    let lastLoaded = false;
    const checkContentLoad = (room, callback = false) => (loaded = true) => {
        // $.ajax({
        //     url: window.config.checkCurrentSession,
        //     data: {
        //         room,
        //     },
        //     success: function(response){
        //         if(loaded && lastLoaded !== response.id && typeof callback === "function"){
        //             callback();
        //             trackEvent({
        //                 type: "sessionView",
        //                 id: response.id
        //             });
        //         }else if(response.id){
        //             trackEvent({
        //                 type: "sessionView",
        //                 id: response.id
        //             });
        //         }
        //         lastLoaded = response.id;
        //     }
        // });
    };
    const contentRecheckingTime = 25000;

    routie({
        // 'lobby': function() {
        //     pages.hide();
        //     pages.filter("#lobby").show();
        //     pageChangeActions();
        //     recordPageView("lobby", "Lobby");
        // },
        // 'room/:id': function(id) {
        //     let toShow = pages.filter("#room-"+id);
        //     if(toShow.length){
        //         pages.hide();
        //         toShow.show();
        //         recordPageView("room-"+id, "Room / "+(toShow.data("name") || id));
        //     }else{
        //         //alert("The doors will open on friday at 4:00 - 6:00 PM.");
        //         $('#information-modal').modal({
        //             backdrop : true
        //         });
        //         routie("expo-hall");
        //     }
        //     pageChangeActions();
        // },
        // "museum":function () {
        //     pages.hide();
        //     let toShow = pages.filter("#museum").show();
        //     if(toShow.length){
        //         toShow.show();
        //         trackEvent({
        //             type: "museumVisit",
        //         });
        //         recordPageView("Museum", "Museum");
        //     }else{
        //         routie(notFoundRoute);
        //     }
        //     pageChangeActions();
        // },
        // "museum/:id":function(id) {
        //     pages.hide();
        //     let toShow = pages.filter("#museum-"+id).show();
        //     if(toShow.length){
        //         toShow.show();
        //         trackEvent({
        //             type: "museumItemView",
        //             id,
        //         });
        //         recordPageView("museum/item-"+id, "Museum / "+(toShow.data("name") || id));
        //     }else{
        //         routie(notFoundRoute);
        //     }
        //     pageChangeActions();
        // },
        // "expo-hall": function(){
        //     pages.hide().filter("#expo-hall-page").show();
        //     pageChangeActions();
        //     recordPageView("expo-hall", "Expo Hall");
        // },
        // "past-videos": function(){
        //     pages.hide().filter("#sessions-archive").show();
        //     pageChangeActions();
        //     recordPageView("past-videos", "Past Videos");
        // },
        // 'booth/:id': function(id) {
        //     pages.hide();
        //     $("#notbooth_menu_toggle i").addClass("mdi-chevron-left-circle");
        //     $("#notbooth_menu_toggle i").removeClass("mdi-chevron-right-circle");
        //     let resbtns =  $(".resourcelist-"+id);
        //     let toShow = pages.filter("#booth-"+id).show();
        //     if(toShow.length){
        //         toShow.show();
        //         pageChangeActions();
        //         trackEvent({
        //             type: "boothVisit",
        //             id,
        //         });
        //         pageChangeActions();
        //         $.ajax({
        //             url: window.config.boothDetails.replace("BID", id),
        //             success: function(html){
        //                 $("#description-"+id).html(html);
        //             }
        //         });
        //         setTimeout(function(){
        //             $(".booth_description").parent().show();
        //             $(".booth_resources").parent().show();
        //             notboothMenus.hide();
        //             notboothmenubutton.removeClass("hidden");
        //             boothMenus.removeClass("hidden");
        //             let callBookingButton = $(".booth_call_booking");
        //             let bookingModal = $("#book-a-call-modal-"+id);
        //             if(bookingModal.length){
        //                 callBookingButton.show();
        //             }else{
        //                 callBookingButton.hide();
        //             }
        //             boothMenus.find('.modal-toggle').unbind().on("click", function(){
        //                 let modalId = $(this).data("modal") + id;
        //                 let modalEl = $("#"+modalId);
        //                 if($(this).data("modal") === "book-a-call-modal-"){
        //                     recordEvent("booking_modal_opened", "Booking Modal Opened / "+modalEl.data("name"), "booking_flow");
        //                     trackEvent({
        //                         type: "boothBookingModalOpened",
        //                         id,
        //                     });
        //                 }else{
        //                     trackEvent({
        //                         type: "boothContentTab",
        //                         id,
        //                         tab: modalId,
        //                     });
        //                 }
        //                 modalEl.modal();
        //             });
        //             boothMenus.find('.show-interest').unbind().on("click", function(){
        //                 trackEvent({
        //                     type: "boothShowInterestButtonClicked",
        //                     id,
        //                 });
        //                 Swal.fire({
        //                     title: 'Do you want to show interest in the booth?',
        //                     text: "Your basic contact information will be shared with booth owner.",
        //                     showCancelButton: true,
        //                     confirmButtonText: `Sure go ahead`,
        //                     cancelButtonText: `Don't Share`,
        //                 }).then((result) => {
        //                     if (result.value) {
        //                         $.ajax({
        //                             url: window.config.showInterestURL.replace("BID", id),
        //                             method: "POST",
        //                             data: {
        //                                 _token: window.config.token,
        //                             }
        //                         });
        //                         Swal.fire('Great choice', 'We have recorded your interest in the booth!', 'success')
        //                     } else {
        //                         Swal.fire('Your interest was not registered!')
        //                     }
        //                 })
        //             });
        //             if(resbtns.length){
        //                 resbtns.show();
        //                 $(".booth_description").parent().hide();
        //                 $(".booth_resources").parent().hide();
        //                 currentresbtns = resbtns;
        //             }
        //         }, 100)
        //         recordPageView("booth/"+id, "Booth - "+ toShow.data("name"));
        //     }else{
        //         routie(notFoundRoute);
        //     }
        // },
        // 'faq': function() {
        //     pages.hide();
        //     let toShow = pages.filter("#faq").show();
        //     if(toShow.length){
        //         toShow.show();
        //     }else{
        //         routie(notFoundRoute);
        //     }
        //     recordPageView("faq", "FAQs");
        //     pageChangeActions();
        // },
        // 'attendees': function() {
        //     pages.hide();
        //     let toShow = pages.filter("#profile").show();
        //     if(toShow.length){
        //         toShow.show();
        //         recordPageView("profile", "Profile");
        //     }else{
        //         routie(notFoundRoute);
        //     }
        //     pageChangeActions();
        // },
        // 'report': function() {
        //     pages.hide();
        //     pages.filter("#reports").show();
        //     recordPageView("reports", "Reports");
        //     pageChangeActions();
        // },
        // 'provisional': function() {
        //     pages.hide();
        //     pages.filter("#provisionals").show();
        //     recordPageView("provisionals", "Provisionals");
        //     pageChangeActions();
        // },
        // 'exterior': function() {
        //     pages.hide();
        //     navs.addClass('hidden');
        //     pages.filter(".initial").show();
        //     exteriorView.prop("currentTime", 0).get(0).play();
        //     setTimeout(function(){
        //         loader.hide();
        //     }, 5000);
        //     exteriorView
        //         .on("canplaythrough", () => loader.hide())
        //         .on("click",function () {
        //             routie("lobby");
        //             // enteringView.prop("currentTime", 0).get(0).play();
        //             // exteriorView.fadeOut();
        //             // enteringView
        //             //     .off("click")
        //             //     .on("ended",function () {
        //             //         enteringView.fadeOut();
        //             //         routie("lobby");
        //             //     });
        //         });
        //     recordPageView("exterior", "Exterior");
        // },
        // 'leaderboard': function() {
        //     pages.hide();
        //     let page = pages.filter("#leaderboard").show();
        //     if(!initializedLeaderboard){
        //         loader.show();
        //         showLeaderboard();
        //         initializedLeaderboard = setInterval(() => showLeaderboard(true), 30000);
        //     }
        //     pageChangeActions();
        //     recordPageView("leaderboard", "Leaderboard");
        // },
        // 'lounge': function() {
        //     pages.hide();
        //     let page = pages.filter("#lounge-page").show();
        //     $("#chat-container").addClass("in-lounge");
        //     $("body").addClass("in-lounge").addClass("right-bar-enabled");
        //     pageChangeActions();
        //     recordPageView("lounge", "Lounge");
        // },
        'auditorium': function() {
            pages.hide();
            let page = pages.filter("#auditorium-room").show();
            pageChangeActions();
            trackEvent({
                type: "audi_visit"
            });
            const loadContent = () => {
                $("#audi-content").empty().append(`<iframe frameborder="0"  class="positioned fill" src="${window.config.auditoriumEmbed}"></iframe>`);
                $(".cc1-chat-win-inpt-wrap input").unbind("mousedown").on("mousedown", function(e){ e.preventDefault(); e.stopImmediatePropagation(); $(e.target).focus() })
            };
            let audiModal = $("#audi-modal");
            $("#play-audi-btn").unbind().on("click", function(){
                // window.open(window.config.auditoriumEmbed+"?t="+Date.now());
                audiModal.modal();
                loadContent();
                checkContentLoad("auditorium")(false);
                contentTicker = setInterval(checkContentLoad("auditorium", loadContent), contentRecheckingTime);
                recordEvent("audi_video_played", "Auditorium Video Played");
            });
            audiModal.unbind().on("hide.bs.modal", function(){
                clearContentTicker();
                $("#audi-content").empty();
            });
            recordPageView("auditorium", "Auditorium");
        },
        // 'celebrations': function() {
        //     pages.hide().filter("#workshop-room").show();
        //     pageChangeActions();
        //     const loadContent = () => {
        //         $("#workshop-content").empty().append(`
        //         <iframe frameborder="0"  class="positioned fill" src="${window.config.auditoriumEmbed}?type=workshop"></iframe>
        //     `);
        //         $(".cc1-chat-win-inpt-wrap input").unbind("mousedown").on("mousedown", function(e){ e.preventDefault(); e.stopImmediatePropagation(); $(e.target).focus() })
        //     };
        //     let workshopModal = $("#workshop-modal");
        //     $("#play-workshop-btn").unbind().on("click", function(){
        //         loadContent();
        //         checkContentLoad("workshop")(false);
        //         workshopModal.modal();
        //         contentTicker = setInterval(checkContentLoad("workshop", loadContent), contentRecheckingTime);
        //     });
        //     workshopModal.unbind().on("hide.bs.modal", function(){
        //         clearContentTicker();
        //         $("#workshop-content").empty();
        //     });
        // },
        // 'caucus-room': function() {
        //     pages.hide().filter("#caucus-room-page").show();
        //     pageChangeActions();
        //     const loadContent = () => {
        //         $("#caucus-room-content").empty().append(`
        //             <iframe frameborder="0"  class="positioned fill" src="${window.config.auditoriumEmbed}?type=caucus"></iframe>
        //         `);
        //         $(".cc1-chat-win-inpt-wrap input").unbind("mousedown").on("mousedown", function(e){ e.preventDefault(); e.stopImmediatePropagation(); $(e.target).focus() })
        //     };
        //     let caucusModal = $("#caucus-modal");
        //     $("#play-caucus-btn").on("click", function(){
        //         loadContent();
        //         checkContentLoad("caucus")(false);
        //         caucusModal.modal();
        //         contentTicker = setInterval(checkContentLoad("caucus", loadContent), contentRecheckingTime);
        //         recordEvent("caucus_video_played", "Caucus Video Played");
        //     });
        //     caucusModal.unbind().on("hide.bs.modal", function(){
        //         clearContentTicker();
        //     });
        //     recordPageView("caucus", "Caucus");
        // },
        // "infodesk": function () {
        //     pages.hide();
        //     let toShow = pages.filter("#infodesk").show();
        //     if(toShow.length){
        //         toShow.show();
        //     }else{
        //         routie(notFoundRoute);
        //     }
        //     pageChangeActions();
        //     recordPageView("infodesk", "Infodesk");
        // },
        // 'photo-booth': function(){
        //     pages.hide().filter("#photo-booth-page").show();
        //     pageChangeActions();
        //     recordPageView("photobooth", "Photo Booth");
        //     let gallery = $("#photo-gallery");
        //     let galleryBtn = $("#gallery");
        //     let capture = $("#photo-capture");
        //     let captureBtn = $("#capture");
        //     capture.hide();
        //     gallery.show();
        //     galleryBtn.hide();
        //     captureBtn.show();
        //     captureBtn.unbind().on("click", function(){
        //         capture.show();
        //         gallery.hide();
        //         captureBtn.hide();
        //         galleryBtn.show();
        //     });
        //     galleryBtn.unbind().on("click", function(){
        //         capture.hide();
        //         gallery.show();
        //         galleryBtn.hide();
        //         captureBtn.show();
        //     });
        //     setTimeout(function(){
        //         $("#chat-toggle").fadeOut();
        //     }, 20);
        // },
        ':route': function(route) {
            routie(notFoundRoute);
            recordEvent("not_found_route", "Not Found / ["+route+"]");
        }
    });
    if(window.location.hash === ""){
        routie("auditorium");
    }else if(window.location.hash.indexOf("#exterior") === -1){
        pageChangeActions();
    }
    setupGamification();
    $("#saveprofile").on("click",saveprofile);
    $(".right-bar-toggle").on("click", function(){
        $(this).find("#chat-unread-count").addClass("hidden");
        recordEvent("chat_opened", "Chat Opened");
    }); //Hide the unread messages count once user opens the chat panel.

    $(".video-play").on("click", function(){
        if($(this).attr("href")){
            let video = $(this).attr("href");
            trackEvent({
                type: "videoView",
                video,
            });
            recordEvent("video_played", "Video / "+(video));
        }
    });

    // const meetContent = $("#meet-content");
    // const meetVideoModal = $("#meet-video");
    // $(".meet-greet-video").on("click", function(e){
    //     e.preventDefault();
    //     let index = $(e.target).closest(".meet-greet-video-row").index();
    //     recordEvent("meet_n_greet", "Meet & Greet Opened / "+(index));
    //     recordPageView("meet_n_greet/"+index, "Meet & Greet / "+ index);
    //     meetContent.empty().html(`<iframe frameborder="0" src="${window.config.meetEmbed}?id=${index}"></iframe>`);
    //     meetVideoModal.modal();
    // });
    // meetVideoModal.on("hide.bs.modal", function(){
    //     recordPageView("go_back");
    //     meetContent.empty();
    // });
    $(".caucus-message").on("click", function(){
        swal("", "Caucus Rooms will open Friday, August 21st at 10pm, EDT (9pm CDT, 8pm MDT, 7pm PDT)")
    });
}
function saveprofile(e, retries = 0) {
    if(e && typeof e.preventDefault === "function"){
        e.preventDefault();
    }
    let url = $("#profileurl").val();
    if(!url.length){
        if(retries <= 5){
            setTimeout(saveprofile(false, ++retries), 2000);
        }
        return false;
    }
    $("#saveprofile").html("Saving...").attr("disabled",true);
    recordEvent("profile_updated", "Profile updated");
    $.ajax({
        url: config.saveprofile,
        method:"POST",
        data:{
            _token : config.token,
            url
        },
        success:function (response) {
            if(response.success){
                $('#profile-modal').modal('hide');
                $(".modal-backdrop").remove();
                Swal.fire({
                    title:  "Saved",
                    text: "Saved Successfully",
                    type: "success",
                });
                $("#saveprofile").html("Save").attr("disabled",false);
                recordEvent("profile_updated", "Profile update success");
                location.reload();
            }
            else{
                Swal.fire({
                    title:  "Error",
                    text: "Please Upload an Image",
                    type: "error",
                });
                $("#saveprofile").html("Save").attr("disabled",false);
                recordEvent("profile_update_failed_1", "Profile update Failed - 1");
            }
        },
        error: function(){
            recordEvent("profile_update_failed_1", "Profile update Failed - 2");
        }
    });
}
function waitForVideosLoad(...videos){
    return Promise.all(videos.map((video, index) => {
        return new Promise(resolve => {
            video.on("canplaythrough", () => resolve());
        });
    }));
}
function showMessage(title, type = "info", options = {}){
    Swal({
        type,
        title,
        ...options
    });
}

function setupGamification(){
    let huntItems = $(".scavenger-item");
    huntItems.on("click", function(){
        let item = $(this);
        showMessage("Congratulations on finding the item.", "success", {
            imageUrl: "https://media.giphy.com/media/2aQUoJgTUKAOc1vk5s/giphy.gif",
            imageWidth: 100,
            imageHeight: 100,
            type: "",
        });
        trackEvent({
            type: "scavengerHunt",
            index: item.data("index"),
            page: item.data("page"),
            name: item.data("name"),
        });
        recordEvent("treasure_hunt", "Treasure Hunt Item Clicked");
    });
}

function trackEvent(options = {}){
    $.ajax({
        url: config.trackEvent,
        method: "POST",
        data: {
            ...options,
            _token: config.token,
        }
    });
}

window.trackEvent = trackEvent;

function showLeaderboard(inLoop = false){
    let list = $("#list-of-people");
    $.ajax({
        url: config.leaderboard,
        method: "POST",
        data: { _token: config.token },
        success: function(leaderboard){
            loader.hide();
            list.html(leaderboard.map(([name, points]) => {
                return `<li class="score-item"><div class="info"><p>${name}</p><span>${points} points</span></div></li>`;
            }).join(""));
        },
        error: function(err){
            loader.hide();
            if(!inLoop){
                showMessage(
                    "Error loading the leaderboard. Please try again in some time",
                    "error"
                );
            }
        }
    });
}

function initMenu(){
    let triggers = $(".custom-dropdown a.menu-trigger");
    triggers.on('click',function(e){
        e.preventDefault();
        $(this).next().toggleClass('active');
    });
}

function initSideMenu(){
    let trigger = $(".mob-menu a");
    let sidebar = $(".sidebar-custom");

    trigger.on('click',function(e){
        e.preventDefault();
        sidebar.toggleClass('enabled');
        if(sidebar.hasClass('enabled')){
            trigger.find('i').removeClass('fa-bars').addClass('fa-times')
        } else{
            trigger.find('i').removeClass('fa-times').addClass('fa-bars')
        }
    });
    sidebar.find('.menu a').on('click',function(){
        if(sidebar.hasClass('enabled')){
            sidebar.removeClass('enabled')
            trigger.find('i').removeClass('fa-times').addClass('fa-bars')
        }
    });
}

const [
    listenForChanges,
    refreshContents,
] = (function(){
    let listeningObjects = {};
    let refreshing = false;
    let lastRefresh = 0;
    const listenForChanges = (key, callback) => {
        if(typeof callback !== "function"){ console.error("Invalid callback provided for listening to changes!"); return; }
        (Array.isArray(key) ? [ ...key ] : [ key ]).map(key => {
            if(!(key in listeningObjects)){
                listeningObjects[key] = [];
            }
            listeningObjects[key].push(callback);
        });
    };

    const refreshContents = () => {
        let now = Date.now();
        if(refreshing && lastRefresh + 5000 > now){ return false; } //If already requesting and last request was less than 5 seconds ago, then dont refresh again
        refreshing = true;
        lastRefresh = now;
        $.ajax({
            url: window.config.contentTickerURL,
            method: "POST",
            data: {
                _token: window.config.token
            },
            success: function (response) {
                if(response.updates && typeof response.updates === "object"){
                    let updates = response.updates;
                    for(let key in updates){
                        if(key in listeningObjects){
                            listeningObjects[key].map(callback => callback(updates[key], key));
                        }
                    }
                }
                refreshing = false;
            },
            error: function(){
                refreshing = false;
                console.log("Error while checking for new content!");
            }
        });
    };

    refreshContents(); //Calling for initialization
    setInterval(refreshContents, 10000); //Will be called every 10 seconds

    return [
        listenForChanges,
        refreshContents, //Helper function to manually refresh the contents - useful in case of some events where we want to know the updates
    ]
})();
window.listenForChanges = listenForChanges;
window.refreshContents = refreshContents;

function isCalendlyEvent(e) {
    return e.data.event &&
        e.data.event.indexOf('calendly') === 0;
};

function getCurrentBoothId(){
    let hash = window.location.hash;
    return hash.startsWith("#booth") ? hash.substr(7) : false;
}

window.addEventListener(
    'message',
    function(e) {
        const boothId = getCurrentBoothId();
        const boothName = $("#book-a-call-modal-"+boothId).data("name");
        if (isCalendlyEvent(e) && boothId) {
            if(e.data.event === "calendly.date_and_time_selected"){
                recordEvent(e.data.event, "Call Slot Selected / "+boothName, "booking_flow");
                trackEvent({
                    type: "boothBookingSlotSelected",
                    id,
                });
            }else if(e.data.event === "calendly.event_scheduled"){
                recordEvent(e.data.event, "Call Scheduled / "+boothName, "booking_flow");
                trackEvent({
                    type: "boothBookingCallScheduled",
                    id,
                });
            }
        }
    }
);

$(document).ready(initApp);