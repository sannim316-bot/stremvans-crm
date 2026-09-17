<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Stremvans CRM')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stremvans.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root{
            --gold:#D6BB00;
            --gold-light:#E8D34D;
            --sidebar:#11151C;
            --body:#F5F7FA;
            --dark:#1C1C1C;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Inter, sans-serif;
            background:var(--body);
        }

        .sidebar{
            position:fixed;
            left:0;
            top:0;
            width:250px;
            height:100vh;
            background:var(--sidebar);
            color:white;
            padding:25px 18px;
        }

        .sidebar-logo{
            text-align:center;
            margin-bottom:40px;
        }

        .sidebar-logo img{
            width:80px;
        }

        .sidebar-logo h5{
            color:var(--gold);
            margin-top:10px;
            font-size:15px;
            font-weight:700;
        }

        .menu a{
            display:flex;
            align-items:center;
            gap:12px;
            padding:14px;
            color:#C7CBD4;
            text-decoration:none;
            border-radius:10px;
            margin-bottom:8px;
            transition:.25s;
        }

        .menu a:hover,
        .menu a.active{
            background:rgba(214,187,0,.15);
            color:var(--gold-light);
        }

        .topbar{
            margin-left:250px;
            background:white;
            height:75px;
            padding:20px 35px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 2px 10px rgba(0,0,0,.05);
        }

        .topbar h4{
            color:#222;
            font-weight:700;
        }

        .topbar-right{
            display:flex;
            align-items:center;
            gap:18px;
        }

        .notification{
            font-size:22px;
            color:#555;
        }

        .profile{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .avatar{
            width:42px;
            height:42px;
            border-radius:50%;
            background:var(--gold);
            color:#222;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
        }

        .content{
            margin-left:250px;
            padding:35px;
        }

        @media(max-width:992px){

            .sidebar{
                width:80px;
            }

            .sidebar h5,
            .sidebar span{
                display:none;
            }

            .topbar,
            .content{
                margin-left:80px;
            }

        }

    </style>

    @yield('styles')

</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">

        <div class="sidebar-logo">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo">
            <h5>STREMVANS CRM</h5>
        </div>

        <div class="menu">

            <a href="/dashboard" class="active">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('clients.index') }}">
    <i class="bi bi-people-fill"></i>
    <span>Clients</span>
</a>

            <a href="#">
                <i class="bi bi-folder-check"></i>
                <span>AOD Forms</span>
            </a>

            <a href="#">
                <i class="bi bi-wallet2"></i>
                <span>Portfolio</span>
            </a>

            <a href="#">
                <i class="bi bi-shield-check"></i>
                <span>Compliance</span>
            </a>

            <a href="{{ route('reports.index') }}">
    <i class="bi bi-bar-chart-fill"></i>
    <span>Reports</span>
</a>
           <a href="{{ route('activity.index') }}">
    <i class="bi bi-clock-history"></i>
    <span>Activity Logs</span>
</a>

<a href="#">
    <i class="bi bi-gear-fill"></i>
    <span>Settings</span>
</a>

        </div>

    </aside>

    <!-- Top Navigation -->
    <header class="topbar">

        <div>
            <h4>@yield('page-title','Dashboard')</h4>
        </div>

        <div class="topbar-right">

            <i class="bi bi-bell notification"></i>

            <div class="profile">
                <div class="avatar">IT</div>

                <div>
                    <strong>IT Administrator</strong><br>
                    <small>Administrator</small>
                </div>
            </div>

        </div>

    </header>

    <!-- Main Content -->
    <main class="content">
        @yield('content')
    </main>
</body>
</html>