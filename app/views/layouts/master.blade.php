<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Obituaries</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <!-- Assets -->
    @assets('application.css', 'application.js')
    <!-- Bootstrap styles -->
    {{--<link rel="stylesheet" href="css/bootstrap.css">--}}
    {{--<link rel="stylesheet" href="css/bootstrap-theme.css">--}}

    <!-- Font-Awesome -->
    {{--<link rel="stylesheet" href="css/font-awesome.css">--}}

    <!-- Google Webfonts -->
    {{--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600|PT+Serif:400,400italic' rel='stylesheet' type='text/css'>--}}

    <!-- Styles -->
    {{--<link rel="stylesheet" href="css/styles-bluegreen.css" id="theme-styles">--}}

    <!--[if lt IE 9]>
        @assets('ie8.css', 'ie8.js')
        {{--<link rel="stylesheet" href="css/ie8.css">--}}
        {{--<script src="js/vendor/google/html5-3.6-respond-1.1.0.min.js"></script>--}}
    <![endif]-->

    {{--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>--}}

    {{--<script>window.jQuery || document.write('<script src="js/jquery-1.9.1.min.js"><\/script>')</script>--}}

    {{--<link rel="stylesheet" href="css/settings-panel.css">--}}
    {{--<script src="js/settings-panel.js" type="text/javascript"></script>--}}
    {{--<script src="http://demo.hackerthemes.com/js/analytics.js" type="text/javascript"></script>--}}
</head>
<body>
    @section('colors')
        @include('layouts._colorswitcher')
    @stop
    @section('header')
        @include('layouts._header')
    @show
    <div class="widewrapper main">
        <div class="container">
            <div class="row">
                <div class="col-md-8 blog-main">
                    @yield('content')
                </div>

                <aside class="col-md-4 blog-aside">
                    @section('aside')
                        <div class="aside-widget">
                            <header>
                                <h3>Options</h3>
                            </header>
                            <div class="body">
                                <ul class="tales-list">
                                    <li><a href="index.html">Create</a></li>
                                    <li><a href="#">List</a></li>
                                    <li><a href="#">Show</a></li>
                                    <li><a href="#">Update</a></li>
                                    <li><a href="#">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    
                        <div class="aside-widget">
                            <header>
                                <h3>Authors Favorites</h3>
                            </header>
                            <div class="body">
                                <ul class="tales-list">
                                    <li><a href="index.html">Email Encryption Explained</a></li>
                                    <li><a href="#">Selling is a Function of Design.</a></li>
                                    <li><a href="#">It’s Hard To Come Up With Dummy Titles</a></li>
                                    <li><a href="#">Why the Internet is Full of Cats</a></li>
                                    <li><a href="#">Last Made-Up Headline, I Swear!</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="aside-widget">
                            <header>
                                <h3>Tags</h3>
                            </header>
                            <div class="body clearfix">
                                <ul class="tags">
                                    <li><a href="#">OpenPGP</a></li>
                                    <li><a href="#">Django</a></li>
                                    <li><a href="#">Bitcoin</a></li>
                                    <li><a href="#">Security</a></li>
                                    <li><a href="#">GNU/Linux</a></li>
                                    <li><a href="#">Git</a></li>
                                    <li><a href="#">Homebrew</a></li>
                                    <li><a href="#">Debian</a></li>                            
                                </ul>
                            </div>
                        </div>
                    @show
                </aside>
            </div>
        </div>
    </div>

    @section('footer')
        @include('layouts._footer')
    @show

    {{--
    <script src="js/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="js/vendor/modernizr/modernizr.js"></script>
    --}}
</body>
</html>