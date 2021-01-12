<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{assetUrl(getField('favicon'))}}">

        @yield('styles')

        <link href="{{ asset('assets/css/auth.css') }}?x=123" rel="stylesheet" type="text/css" />
        
        @yield('styles_after')
        @yield('scripts_before')
        <style>
            .bg-image{
                position: fixed;
                width: 100vw;
                height: 100vh;
                z-index: -1;
                filter: blur(4px);
                object-fit: cover;
                object-position: 55% 0;
            }
            .lh2{
                line-height: 2em;
            }
            body.auth{
                background-image: url("{{assetUrl(getField('login_background'))}}");
                background-position:bottom;
            }
        </style>
    </head>

    <body class="auth">
        <!-- <img src="{{ asset("images/Exterior.jpg") }}" class="bg-image" alt=""> -->
        <div class="container">
            <div class="login-container {{ Request::is('*/register', '/') ? 'two-cols' : '' }} {{ Request::is('*/verify', '/') ? 'verify' : '' }}">
                <div class="login-header">
                    <a href="{{ route('login') }}" class="logo">
                        <img src="{{ asset('assets/images/church-logo.jpg') }}" alt="PUMB" class="img-responsive">
                    </a>
                    <p class="hidden-v">For an immersive experience, please log in using a PC, Mac or Smart Tablet Device (No Mobile Phones). Also, please use one of these supported browsers to access the platform: <a href="https://www.google.com/chrome/">Google Chrome</a>, Microsoft Edge, or Firefox.</p>
                    <p class="mb-0 hidden-v">@yield('subtitle-text')</p>
                </div>
                <div class="form">
                    @yield('form')
                    <p class="text">By logging in and using the platform, you hereby accept our <a href="{{ route("privacyPolicy") }}" >Privacy Policy</a>. For more details <a href="{{ route("faq") }}">read the FAQs</a></p>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="login-footer-container">
                @yield("extra")
            </div>
        </div>

        
        <div class="device-orentation disabled">
            <div class="inner">
                <div class="icon">
                    <svg id="Capa_1" enable-background="new 0 0 512 512" height="32" viewBox="0 0 512 512" width="32" xmlns="http://www.w3.org/2000/svg"><g><path d="m356.225 417v-76-55-186c-49.254 0-88.509-10-137.764-10-50.745 0-101.49 0-152.236 0v337h150.902c49.7 0 89.399-10 139.098-10z" fill="#e9f6ff"/><path d="m66.225 166h120v30h-120z" fill="#d2e4fd"/><path d="m66.225 226h75v30h-75z" fill="#d2e4fd"/><path d="m356.225 64.5c0-35.565-28.935-59.5-64.5-59.5l-75.5-5h-85.5c-35.565 0-64.5 28.935-64.5 64.5v25.5h150l140-5z" fill="#4c607e"/><path d="m66.225 447.5c0 35.565 28.935 64.5 64.5 64.5h85.5l75.5-5c35.565 0 64.5-23.935 64.5-59.5v-22.5l-140-5h-150z" fill="#4c607e"/><path d="m216.225 420h150v-79-55-196h-150z" fill="#d2e4fd"/><path d="m301.725 0h-85.5v90h150v-25.5c0-35.565-28.935-64.5-64.5-64.5z" fill="#374965"/><path d="m216.225 512h85.5c35.565 0 64.5-28.935 64.5-64.5v-27.5h-150z" fill="#374965"/><path d="m440.775 211.377-37.427-37.426-37.123 32.123-37.123-37.123-42.427 42.426 37.124 37.123-37.124 37.123 42.427 42.426 37.123-37.123 37.123 32.123 37.427-37.426-37.124-37.123z" fill="#e58f22"/><path d="m445.775 285.623-37.124-37.123 37.124-37.123-42.427-42.426-37.123 37.123v84.852l37.123 37.123z" fill="#df6426"/></g></svg>
                </div>
                <p>For an immersive experience, please login using a Tablet Device or a Computer/PC, not a mobile phone</p>
            </div>
        </div>

        @yield('scripts_after')

        <script>
            (function () {
                let deviceElem = document.querySelector('.device-orentation');

                function isMobile() {
                    let check = false;
                    (function(a){
                        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) 
                        check = true;
                    })(navigator.userAgent||navigator.vendor||window.opera);
                    return check;
                }
                
                window.addEventListener("DOMContentLoaded", function(){
                    window.innerWidth < 600 ?  deviceElem.classList.remove('disabled') : deviceElem.classList.add('disabled'); 
                }, false);
            })();
        </script>
    </body>
</html>