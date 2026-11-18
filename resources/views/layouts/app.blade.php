<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Student Result Portal')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body>
    <header class="site-header">
        <a href="{{ route('students.index') }}" class="brand">
            <span class="brand-mark">KY</span>
            <span>Student Result Portal</span>
        </a>
        <nav>
            <a href="{{ route('students.index') }}">Students</a>
            @auth
                <a href="{{ route('students.create') }}">Add student</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="link-btn">Logout ({{ auth()->user()->name }})</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </nav>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="flash success">{{ session('success') }}</div>
        @endif

        @if ($errors->any() && !View::hasSection('hide_error_summary'))
            <div class="flash danger">
                <strong>Please fix the following:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        &copy; {{ date('Y') }} Khwaja Yunus Ali University &middot; Web Engineering Lab
    </footer>
</body>
</html>
