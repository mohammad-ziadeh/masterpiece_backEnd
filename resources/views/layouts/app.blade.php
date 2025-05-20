<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LMC</title>

    {{-- Meta Tags --}}
    <meta name="description"
        content="LMC is a centralized LMS that helps trainers, students, and admins manage education efficiently with integrated tools, automated scoring, and a gamified learning system.">
    <meta name="keywords"
        content="LMS, Learning Management System, Education Platform, Laravel, Flutter, Online Learning, Trainer Tools, Student Portal, Task Management, Orange Coding Academy">
    <meta name="author" content="Mohammad Emad Ziadeh">
    <meta name="theme-color" content="#321947">
    {{-- Facebook --}}
    <meta property="og:title" content="LMC - Learning Management Center">
    <meta property="og:description"
        content="All-in-one platform for trainers and students to manage learning efficiently. Features include task submission, point system, badges, and more.">
    <meta property="og:type" content="website">
    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="LMC - Smart Learning Platform">
    <meta name="twitter:description"
        content="A gamified, automated LMS that empowers trainers and motivates students with badges, point systems, and more.">
    {{-- End Meta Tags --}}

<link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEJ6uS+YbU6jYd42e29+bT5YrD1orY73Sg/4bPv6c7l9FzvkcHYOoHkaM2s+V" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/breadcrumbs.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mainTablesCards.css') }}">
    <link rel="stylesheet" href="{{ asset('css/snowSwitch.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tinymce.css') }}">
    <link rel="stylesheet" href="{{ asset('css/score.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dayNight.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
    <link rel="stylesheet" href="{{ asset('css/leadBoard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 ">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white  shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}

                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        @include('layouts.footer')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'trainer')
        <script>
            (function() {
                if (!window.chatbase || window.chatbase("getState") !== "initialized") {
                    window.chatbase = (...arguments) => {
                        if (!window.chatbase.q) {
                            window.chatbase.q = []
                        }
                        window.chatbase.q.push(arguments)
                    };
                    window.chatbase = new Proxy(window.chatbase, {
                        get(target, prop) {
                            if (prop === "q") {
                                return target.q
                            }
                            return (...args) => target(prop, ...args)
                        }
                    })
                }
                const onLoad = function() {
                    const script = document.createElement("script");
                    script.src = "https://www.chatbase.co/embed.min.js";
                    script.id = "XgSLUsnkc0eEO4QaZydRu";
                    script.domain = "www.chatbase.co";
                    document.body.appendChild(script)
                };
                if (document.readyState === "complete") {
                    onLoad()
                } else {
                    window.addEventListener("load", onLoad)
                }
            })();
        </script>
    @else
        <script>
            (function() {
                if (!window.chatbase || window.chatbase("getState") !== "initialized") {
                    window.chatbase = (...arguments) => {
                        if (!window.chatbase.q) {
                            window.chatbase.q = []
                        }
                        window.chatbase.q.push(arguments)
                    };
                    window.chatbase = new Proxy(window.chatbase, {
                        get(target, prop) {
                            if (prop === "q") {
                                return target.q
                            }
                            return (...args) => target(prop, ...args)
                        }
                    })
                }
                const onLoad = function() {
                    const script = document.createElement("script");
                    script.src = "https://www.chatbase.co/embed.min.js";
                    script.id = "xYRmpdfuWFIFHbapscPey";
                    script.domain = "www.chatbase.co";
                    document.body.appendChild(script)
                };
                if (document.readyState === "complete") {
                    onLoad()
                } else {
                    window.addEventListener("load", onLoad)
                }
            })();
        </script>
    @endif



</body>

</html>
