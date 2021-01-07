@if(isOpenForPublic("chat"))
<div id="chat-container" class="right-bar theme-chat"></div>
<a href="javascript:void(0);" id="chat-toggle" class="nav-link right-bar-toggle theme-chat chat-bubble hide-on-exterior hidden">
    <i class="fe-message-square"></i>
    <span id="chat-unread-count" class="badge badge-danger font-15  badge-pill hidden"></span>
</a>
<div class="rightbar-overlay"></div>
@endif
<div class="consent-notification hide-on-exterior">
    <h4>Subscribe to Notifications.</h4>
    <p>We'll send you  notifications about the event, chats and other cool stuff. Sounds good?</p>
    <div class="flex">
        <button class="btn theme-btn primary mr-2" data-consent="true">Yup</button>
        <button class="btn theme-btn danger mr-2" style="background: #fff; border-color: #9090904d;" data-consent="skip">Nope</button>
        <button class="btn theme-btn danger" style="background: #fff; border-color: #9090904d;" data-consent="false">Never Show</button>
    </div>
</div>

