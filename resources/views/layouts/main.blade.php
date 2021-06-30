<!DOCTYPE html>
<html>
<head>
    @yield('top-head')
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <script src="https://kit.fontawesome.com/f7cb5c0d29.js" crossorigin="anonymous"></script>
    @yield('bottom-head')
</head>
<body>
    @yield('top-body')
    <header style="border-bottom: solid #ddd 1px;">
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="/"><img src="{{asset('img/shuttle-bus-logo.png')}}" height="28"></a>
                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>
            <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar-item">Home</a>
                    <a class="navbar-item">Documentation</a>
                    <div class="navbar-item has-dropdown is-hoverable"><a class="navbar-link">More</a>
                        <div class="navbar-dropdown">
                            <a class="navbar-item">About</a>
                            <a class="navbar-item">Jobs</a>
                            <a class="navbar-item">Contact</a>
                            <hr class="navbar-divider">
                            <a class="navbar-item">Report an issue</a>
                        </div>
                    </div>
                </div>
                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-primary"><strong>Sign up</strong>&nbsp;&nbsp;<i class="fas fa-signature"></i></a>
                            <a class="button is-light"><strong>Log in</strong>&nbsp;&nbsp;<i class="fas fa-sign-in-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    @yield('content')
    <footer></footer>
    @yield('bottom-body')
    <style>
    </style>
</body>
</html>
