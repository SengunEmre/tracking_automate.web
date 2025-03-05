<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <!-- Bootstrap 5 CSS (Dark Theme) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Optional: Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom Styles (if any) -->
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #1f1f1f;
        }
        .sidebar .nav-link {
            color: #aaa;
        }
        .sidebar .nav-link:hover {
            color: #fff;
        }
        .chart-container {
            max-width: 100%;
            height: 400px;
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar py-3">
                <div class="text-center mb-4">
                    <h3>Operation</h3>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">
                            <i class="fa fa-home"></i> Home
                        </a>
                    </li>
                    <!-- Add other nav items here if you like -->
                    <li class="nav-item">
                        <a class="nav-link" href="/logs">
                            <i class="fa fa-chart-line"></i> Logs
                        </a>
                    </li>
                    <!-- etc. -->
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>

    @stack('scripts')
</body>
</html>
