<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome | HR Structure Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Rubik:ital,wght@0,300..900;1,300..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Winky+Sans:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --cmu-purple: #800080;
            --cmu-accent: #d1b3ff;
            --cmu-bg: #f8f5fc;
        }

        body {
            margin: 0;
            font-family: 'Rubik', sans-serif;
        }

        h1,
        h2 {
            font-family: 'Rubik', cursive;
        }

        .bg-blur {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/d99186c8-cb5a-41d7-a864-7c46c293360b.jpg') }}") no-repeat center center;
            background-size: cover;
            filter: blur(8px) brightness(0.8);
            z-index: 1;
        }

        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
            position: relative;
            z-index: 2;
            color: #fff;
            animation: fadeIn 1.2s ease-in-out;
        }

        .btn-get-started {
            padding: 12px 32px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            background-color: #fff;
            color: var(--cmu-purple);
            border: none;
            transition: all 0.3s ease;
            animation: slideUp 1.4s ease;
        }

        .btn-get-started:hover {
            background-color: var(--cmu-accent);
            color: #fff;
        }

        h1 {
            font-weight: 800;
            font-size: 3rem;
            animation: slideDown 1s ease-in-out;
        }

        p.lead {
            font-family: 'Ubuntu', sans-serif;
            font-size: 1.2rem;
            animation: fadeIn 1.2s ease-in-out;
        }

        .logo-img {
            width: 250px;
            height: auto;
            border-radius: 16px;
            transition: transform 0.3s ease-in-out;
        }

        .logo-img:hover {
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="bg-blur"></div>

    <section class="hero">
        <div class="container">
            <img src="{{ asset('images/LogoMEDICINE-TH.png') }}" alt="Med CMU" class="logo-img mb-4"><br />
            <h1 class="mb-4">Welcome to HR Structure Dashboard</h1>
            <p class="lead mb-5">ยินดีต้อนรับสู่ระบบวิเคราะห์ข้อมูลโครงสร้างงบการจ้างสำหรับฝ่ายทรัพยากรบุคคล</p>
            <a href="/structure" class="btn btn-get-started">Get Started</a>
        </div>
    </section>

</body>

</html>