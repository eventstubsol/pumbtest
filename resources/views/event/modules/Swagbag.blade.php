<div class="modal fade theme-modal" id="swagbag-modal" tabindex="-1" role="dialog" aria-labelledby="swagbaglistLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="resourceslistLabel"><span class="image-icon swagbag"></span> SwagBag</h4>
                <div class="form-group filters search-box">
                    <label class="search has-icon search" for="swagsearch">
                        <input type="text" placeholder="Search items ..." name="swagsearch" id="swagsearch" data-action="swagsearch">
                    </label>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="doc-lists swagbag-list" id="swagbag-items-list" data-simplebar data-simplebar-auto-hide="false">
                    <div class="doc-item header row justify-content-between align-items-center">
                        <div class="d-inline-flex align-items-center flex-grow-1">
                            <div class="doc-title mb-0 flex-grow-1">
                                <h4>Email Items to your mail</h4>
                            </div>
                        </div>
                        <div class="d-inline-flex actions">
                            <button class="btn theme-btn primary has-icon email mr-2 " type="button" name="email-all" id="sendEmailBtn">Mail Me</button>
                            <button class="btn theme-btn danger remove-multiple bag-item has-icon delete" disabled type="button" name="remove-all">Remove Selected</button>
                        </div>
                    </div>
                </div>
                <p class="message hidden text-center">No items in Swag Bag. Checkout Resource section to add.</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->