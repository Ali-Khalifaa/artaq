<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('messages.Dorr') | @lang('messages.Track Booking')</title>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('assets/images/brand-logos/favicon.svg')}}" type="image/x-icon">
    <link id="style" href="{{asset('assets/libs/bootstrap/css/bootstrap.rtl.min.css')}}" rel="stylesheet">
    <style>
    html,
    body {
        margin: 0;
        padding: 0;
        font-family: 'Maven Pro', sans-serif;
    }

    img {
        max-width: 100%;
        height: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    body {
        padding: 15px;
        overflow-x: hidden;
    }


    /* remove the focus from all input fields.*/
    input:focus,
    select:focus,
    textarea:focus,
    button:focus {
        outline: none;
    }

    .termsAndConditions {
        z-index: 1000;
        border-radius: 3px;
        position: absolute;
        top: 50%;
        left: 50%;
        height: 100%;
        width: 100%;
        background-color: rgb(255, 255, 255);
        transform: translate(-50%, -50%);
        max-width: 900px;
        display: flex;
        flex-direction: column;
        align-items: center;
        transform: all .2s;
        backface-visibility: hidden;
    }

    .termsAndConditionsHeading {
        margin-top: 70px;
        margin-bottom: 30px;
        font-size: 32px;
    }

    .termsParagraphIntro {
        margin-left: 15px;
        margin-right: 15px;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .spangleWelcome {
        font-weight: 500;
    }

    .serviceLeadingSection {
        width: 80%;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .sn {
        font-size: 32px;
        padding-right: 5px;
    }

    .st {
        font-size: 32px;
    }

    .spl {
        margin-top: 15px;
        margin-bottom: 15px;

    }

    .serviceInfoContainer {
        position: relative;
        width: 100%;
    }

    .serviceLead {
        font-weight: 700;
        margin-left: 15px;
        margin-top: 15px;
        margin-block-end: 5px;

    }

    .serviceDetails {
        margin-left: 15px;
    }

    .displayNone {
        display: none;
    }

    .secionLine {
        height: 40px;
        width: 5px;

        position: absolute;
        top: 7px;
    }

    /*Font Colours below*/
    .lightGreen {
        color: rgb(85, 189, 134);
    }

    .blue {
        color: #2998ff;
    }

    .orange {
        color: #ff7730;
    }

    .purple {
        color: #2a0073
    }

    /*Set the colours for the lines*/

    .lineColorGreen {
        background-image: linear-gradient(to right bottom, rgb(85, 189, 134), rgb(11, 103, 92));
    }

    .lineColorBlue {
        background-image: linear-gradient(to right bottom, #2998ff, #5643fa);
    }

    .lineColorOrange {
        background-image: linear-gradient(to right bottom, #ffb900, #ff7730);
    }

    .lineColorPurple {
        background-image: linear-gradient(to bottom right, #b25f88, #2a0073)
    }

    .closeTerms {
        border-bottom: 1px solid black;
        margin-top: 15px;
        margin-bottom: 15px;
        padding-bottom: 5px;
    }

    .fadeIn {
        animation-name: fadeIn;
        animation-duration: .8s;
        animation-timing-function: ease-out;
        z-index: 1001;
    }

    @keyframes fadeIn {
        0% {

            opacity: 0;
        }

        100% {

            opacity: 1;
        }
    }

    /* .fadeIn * {
                padding-left: 20px;
                padding-right: 7px;
            } */
    </style>
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.css"
        type="text/css">

    @vite(['resources/js/single-components.js'])
</head>

<body>
    <div class="termsAndConditions fadeIn">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top w-100">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="{{asset('assets/images/brand-logos/desktop-dark.png')}}" alt="..." height="36"
                        width="220">
                </a>

            </div>
        </nav>

        <div class="container">
            <div class="text-center p-5 my-auto">
                <div class="row align-items-center justify-content-center h-100">
                    <div class="col-xl-7">
                        <p class="error-text mb-sm-0 mb-2" style="font-size: 100px;font-weight: bold;color:#ff715a;">404</p>
                        <p class="fs-18 fw-semibold mb-3">Oops 😭,The page you are looking for is not available.</p>
                        <div class="row justify-content-center mb-5">
                            <div class="col-xl-6">
                                <p class="mb-0 op-7">We are sorry for the inconvenience,The page you are trying to
                                    access has been removed or never been existed.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer mt-auto py-3 bg-white text-center">
            <div class="container">
                <span class="text-muted"> Copyright © <span>{{ now()->year}}</span></span>
            </div>
        </footer>
    </div>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.js">
    </script>

</body>

</html>