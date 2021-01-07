// Resources

$(document).ready(function(){

    let swagBag = [];
    let resources = $(".resource");


    function loadSwagBag(){
        $.ajax({
            url: config.getswagBag,
            success: function(response){
                if(response.success){
                    swagBag = response.bag;
                    setupResourceButtons();
                }
            }
        });
    }

    function setupResourceButtons(){
       resources.find(".add-to-bag").addClass("hidden").filter(".add").removeClass("hidden");
        for(let item of swagBag){
            let r = resources.filter(".r-"+item.resources_id);
            r.find(".add-to-bag").toggleClass("hidden");
        }
    }

    //show correct buttons as per bag contents on load of modal
    $("#resources-modal").on("shown.bs.modal", function(){
        recordEvent("resources_modal_opened", "Resources Modal Opened");
        setupResourceButtons();
    });

    //Filter all modal resources as per booth
    $("#resources-select").on("change", function(){
        let x=$(this).val();
        if(x.length){
            resources.not(".no-filter").hide().filter(".resource-"+x).show();
        }else{
            resources.show();
        }
    });

    $("#swagsearch").on("keyup", function(){
        var searchVal = $(this).val();
        var swagItems = $('.swagbag-list .doc-item.resource');

        if ( searchVal != '' ) {
            recordEvent("swag_search", "Swag bag searched");
            swagItems.addClass('hidden');
            swagItems.each(function(){
                var $this = $(this);
                var title = $this.find('label h4').text();
                if(title.toLowerCase().includes(searchVal.toLowerCase())){
                    $this.removeClass('hidden');
                }
            });
        } else {
            swagItems.removeClass('hidden');
        }
    });
    $("#resourcesearch").on("keyup", function(){
        var searchVal = $(this).val();
        var swagItems = $('.resources-list .doc-item.resource');

        if ( searchVal != '' ) {
            recordEvent("resources_search", "Resources searched");
            swagItems.addClass('hidden');
            swagItems.each(function(){
                var $this = $(this);
                var title = $this.find('.searchresource').text();
                if(title.toLowerCase().includes(searchVal.toLowerCase())){
                    $this.removeClass('hidden');
                }
            });
        } else {
            swagItems.removeClass('hidden');
        }
    });
    $("#reportsearch").on("keyup", function(){
        var searchVal = $(this).val();
        var swagItems = $('.report-list .doc-item.resource');

        if ( searchVal != '' ) {
            recordEvent("report_search", "Reports searched");
            swagItems.addClass('hidden');
            swagItems.each(function(){
                var $this = $(this);
                var title = $this.find('.searchreport').text();
                if(title.toLowerCase().includes(searchVal.toLowerCase())){
                    $this.removeClass('hidden');
                }
            });
        } else {
            swagItems.removeClass('hidden');
        }
    });
    $("#provisiosearch").on("keyup", function(){
        var searchVal = $(this).val();
        var swagItems = $('.provision-list .doc-item.resource');

        if ( searchVal != '' ) {
            recordEvent("provisions_search", "Provisional Groups searched");
            swagItems.addClass('hidden');
            swagItems.each(function(){
                var $this = $(this);
                var title = $this.find('.searchprovision').text();
                if(title.toLowerCase().includes(searchVal.toLowerCase())){
                    $this.removeClass('hidden');
                }
            });
        } else {
            swagItems.removeClass('hidden');
        }
    });

    //Add / remove from bag
    function bindAddToBagButtons(){
        $(document).on("click", ".add-to-bag", function(){
            let t = $(this);
            if(t.hasClass("add")){
                //Add to bag for reports
                recordEvent("swagbag_add", "Item Added to Swag Bag");
                if(t.hasClass("report-bag")){
                    $.ajax({
                        url: config.addtoBag,
                        data:{ resource: t.data("resource") },
                        success: function(response){
                            if(response.success){
                                swagBag = response.bag;
                                setupResourceButtons();
                            }
                        }
                    });
                    $.ajax({
                        url: config.addtoBag,
                        data:{ resource: t.data("resource2") },
                        success: function(response){
                            if(response.success){
                                swagBag = response.bag;
                                setupResourceButtons();
                            }
                        }
                    });
                    $.ajax({
                        url: config.addtoBag,
                        data:{ resource: t.data("video") },
                        success: function(response){
                            if(response.success){
                                swagBag = response.bag;
                                setupResourceButtons();
                            }
                        }
                    });
                }else{
                    $.ajax({
                        url: config.addtoBag,
                        data:{ resource: t.data("resource") },
                        success: function(response){
                            if(response.success){
                                swagBag = response.bag;
                                setupResourceButtons();
                            }
                        }
                    });
                }
            }else if(t.hasClass("remove")){
                let resource = t.data("resource");
                swagBag = swagBag.map(item => item.resources_id === resource ? false : item).filter(Boolean);
                recordEvent("swagbag_remove", "Removed Item from Swag Bag");
                setupResourceButtons();
                $.ajax({
                    url: config.deletefromBag,
                    data:{
                        resource
                    },
                    success: function(response){
                        if(response.success){
                            swagBag = response.bag;
                            setupResourceButtons();
                            setupSwagBag();
                        }
                    }
                });
                if(t.hasClass("bag-item")){
                    t.closest(".row").remove();
                }
            }
            t.parent().find(".add-to-bag").toggleClass("hidden");
        });
        // $(document).on("click",".open-pdf",function (e) {
        //     e.preventDefault();
        //     let url = $(this).attr("href");
        //     let title = $(this).attr("title");
        //     $(".pdf").attr("src",url);
        //     $(".pdf-title").html(title);
        // });
    }

    function setupSwagBag(){
        const container = $("#swagbag-items-list");
        const simpleBar = container.find('.simplebar-content');
        const items = swagBag.filter( function(el){ return !!el.resource||!!el.report||!!el.provision });
        container.find(".doc-item:not(.header)").remove();
        if(items.length > 0) {
            container.find(".doc-item.header").removeClass('inactive');
            $('p.message').addClass('hidden');
        } else{
            container.find(".doc-item.header").addClass('inactive');
            $('p.message').removeClass('hidden');
        }
        for (let item of items){
            if(item.resource)
            {
                let $resource = item.resource;
                let resourceElem = $(`<div class="doc-item row justify-content-between align-items-center resource r-${$resource.id}"></div>`);
                let resourceData = $(`<div class="d-inline-flex flex-grow-1 align-items-center"></div>`);
                let resourceTitle = $(`<div class="doc-title flex-grow-1"></div>`);
                let titleToShow = $resource.title;
                if("booth" in $resource && "name" in $resource.booth){
                    titleToShow += ` - ${$resource.booth.name}`;
                }
                let resourceTitleData = $(`<div class="checkbox d-flex flex-grow-1"><input type="checkbox" class='theme-checkbox' id='swag-${$resource.id}' name="swag-${$resource.id}" value='${$resource.id}'><label for='swag-${$resource.id}' class="d-flex flex-grow-1 align-items-center"><span class="image-icon pdf"></span><h4>${titleToShow}</h4></label></div>`);
                //let resourceTitleData = $(`<span class="image-icon pdf"></span><h4>${$resource.title}</h4>`);
                let resourceBtns = $(`<div class="d-inline-flex actions"></div>`);
                let btnView = $(`<a class="btn primary _df_button theme-btn plain  mr-2" title="${$resource.title}" href="${assetUrl($resource.url)}" source="${assetUrl($resource.url)}" type="button" name="button">View</a>`);
                let btnRemove = $(`<button class="btn theme-btn add-to-bag danger mr-2 remove bag-item has-icon delete" data-resource="${$resource.id}" type="button" name="button"> Remove</button>`);
                //let btnEmail = $(`<button class="btn theme-btn primary has-icon email" data-resource="${$resource.id}" type="button" name="button"> Email</button>`);
                resourceTitle.append(resourceTitleData);
                resourceData.append(resourceTitle);
                resourceBtns.append(btnView);
                if(!(item.permanent)) {
                    resourceBtns.append(btnRemove);
                }

                resourceElem.append(resourceData);
                resourceElem.append(resourceBtns);
                simpleBar.length ? simpleBar.append(resourceElem) : container.append(resourceElem);
            }else if (item.report) {
                let $report = item.report;
                let resourceElem = $(`<div class="doc-item row justify-content-between align-items-center resource r-${$report.id}"></div>`);
                let resourceData = $(`<div class="d-inline-flex flex-grow-1 align-items-center"></div>`);
                let resourceTitle = $(`<div class="doc-title flex-grow-1"></div>`);
                let resourceTitleData = $(`<div class="checkbox d-flex flex-grow-1"><input type="checkbox" class='theme-checkbox' id='swag-${$report.id}' name="swag-${$report.id}" value='${$report.id}'><label for='swag-${$report.id}' class="d-flex flex-grow-1 align-items-center"><span class="image-icon pdf"></span><h4>${$report.title}</h4></label></div>`);
                let resourceBtns = $(`<div class="d-inline-flex actions"></div>`);
                let btnRemove = $(`<button class="btn theme-btn add-to-bag danger mr-2 remove bag-item has-icon delete" data-resource="${$report.id}" type="button" name="button"> Remove</button>`);
                resourceTitle.append(resourceTitleData);
                resourceData.append(resourceTitle);
                if($report.resources) {
                    $report.resources.forEach((resource, i) => {
                        let btnView = $(`<a class="btn primary _df_button theme-btn plain  mr-2" title="${resource.title}" href="${assetUrl(resource.url)}" source="${assetUrl(resource.url)}" type="button" name="button">View ${i + 1}</a>`);
                        resourceBtns.append(btnView);
                    });
                }
                let btnPlay = "";
                if($report.video && $report.video.title && $report.video.url){
                    btnPlay = $(`<a class="btn primary theme-btn plain video-play mr-2" title="${$report.video.title}" href="${$report.video.url}" type="button" name="button">Play Video</a>`);
                }
                resourceBtns.append(btnPlay);
                resourceBtns.append(btnRemove);
                resourceElem.append(resourceData);
                resourceElem.append(resourceBtns);
                simpleBar.length ? simpleBar.append(resourceElem) : container.append(resourceElem);
            }else if (item.provision) {
                    console.log(item.provision)
                    let $provision = item.provision;
                    let resourceElem = $(`<div class="doc-item row justify-content-between align-items-center resource r-${$provision.id}"></div>`);
                    let resourceData = $(`<div class="d-inline-flex flex-grow-1 align-items-center"></div>`);
                    let resourceTitle = $(`<div class="doc-title flex-grow-1"></div>`);
                    let resourceTitleData = $(`<div class="checkbox d-flex flex-grow-1"><input type="checkbox" class='theme-checkbox' id='swag-${$provision.id}' name="swag-${$provision.id}" value='${$provision.id}'><label for='swag-${$provision.id}' class="d-flex flex-grow-1 align-items-center"><span class="image-icon pdf"></span><h4>${$provision.title}</h4></label></div>`);
                    let resourceBtns = $(`<div class="d-inline-flex actions"></div>`);
                    let btnRemove = $(`<button class="btn theme-btn add-to-bag danger mr-2 remove bag-item has-icon delete" data-resource="${$provision.id}" type="button" name="button"> Remove</button>`);
                    resourceTitle.append(resourceTitleData);
                    resourceData.append(resourceTitle);
                    if ($provision.resource) {
                        $provision.resource.forEach((resource, i) => {
                            let btnView = $(`<a class="btn primary _df_button theme-btn plain  mr-2" title="${resource.title}" href="${assetUrl(resource.url)}" source="${assetUrl(resource.url)}" type="button" name="button">View ${i + 1}</a>`);
                            resourceBtns.append(btnView);
                        });
                    }
                    let btnPlay = $(`<a class="btn primary theme-btn plain video-play mr-2" title="${$provision.video.title}" href="${$provision.video.url}" type="button" name="button">Play Video</a>`);
                    resourceBtns.append(btnPlay);
                    resourceBtns.append(btnRemove);
                    resourceElem.append(resourceData);
                    resourceElem.append(resourceBtns);
                    simpleBar.length ? simpleBar.append(resourceElem) : container.append(resourceElem);
                }
        }
        $(".video-play").unbind().YouTubePopUp( { autoplay: 1 } );
    }

    $(".report-select").on("change", function(){
        let x=$(this).val();
        if(x=="all")
        {
            $(".reports").show();
        }else {
            $(".reports").hide().filter(".rp-" + x).show();
        }
    });

    //Initializing
    $("#swagbag-modal").on("shown.bs.modal", setupSwagBag);
    
    $("#allswags").on("change", function(e) {
        if($(this).is(':checked')){
            $('.theme-checkbox').prop('checked',true).trigger("change");
        } else{
            $('.theme-checkbox').prop('checked',false).trigger("change");
        }
    }); 

    $("#swagbag-items-list").on("change", 'input.theme-checkbox',  function() {
        //let selectAll = $("#allswags");
        let allItems = $('input.theme-checkbox').length;
        let selected = $('input.theme-checkbox:checked').length;
        let btns = $(".doc-item.header").find('button.remove-multiple');
        selected ? btns.prop('disabled',false) : btns.prop('disabled',true);
        //selected === allItems ? selectAll.prop('checked',true) : selectAll.prop('checked',false);
    }); 

    $('.remove-multiple').on('click',function(){
        recordEvent("swagbag_remove_multiple_modal", "Removed multiple Items Modal Shown");
        $('#confirm-modal').modal('show');
    });

    $('#confirm-modal').on('show.bs.modal', function (event) {
        let modal = $(this);
        let removables = $('input.theme-checkbox:checked').map(function(){
            return $(this).val();
        }).get();
        let files = removables.length > 1 ? `${removables.length} files` : `${removables.length} file`;
        modal.find('.title > span').text(files);
        $('#remove-multiple-confirm').unbind().on('click',function(){
            removeMultiple(removables);
        });
    });

    function removeMultiple(items){
        recordEvent("swagbag_remove_multiple", "Removed multiple Items from Swag Bag");
        let resource = items;
        swagBag = swagBag.map(item => resource.includes(item.resources_id) ? false : item).filter(Boolean);
        $.ajax({
            url: config.deletefromBag,
            data:{
                resource
            },
            success: function(response){
                if(response.success){
                    swagBag = response.bag;
                    $("#allswags").prop('checked',false).trigger('change');
                    $('#confirm-modal').modal('hide');
                    setupSwagBag();
                }
            }
        });

    }

    loadSwagBag();
    bindAddToBagButtons();
})