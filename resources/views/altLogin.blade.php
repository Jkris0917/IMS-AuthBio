<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>IMS | Login</title>
    <script defer src="{{ asset('face-api.min.js') }}"></script>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background Video */
        #bg-video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
        }

        /* Glassmorphic Login Form */
        .login-form {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-form h2 {
            font-size: 24px;
            color: white;
            margin-bottom: 20px;
        }

        .login-form input {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .login-form input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .login-form button {
            background-color: limegreen;
            color: white;
            font-weight: bold;
        }

        .login-form button:hover {
            background-color: darkgreen;
        }
    </style>
</head>

<body>
    <!-- Background Video -->
    <video id="bg-video" autoplay muted loop>
        <source src="{{ asset('bg.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Header -->
    <header class="nav-header position-fixed w-100 py-3 d-flex justify-content-between align-items-center"
        style="background: rgba(0, 0, 0, 0.3); z-index: 10;">
        <div class="nav-left d-flex align-items-center gap-2 text-white">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="logo" style="width: 35px; height: 35px;">
            <span class="ims-title fs-5 fw-bold">IMS</span>
        </div>
        <div class="nav-right">
            <a href="{{ route('home') }}" class="btn btn-success fw-bold">Face Login</a>
        </div>
    </header>

    <!-- Login Form -->
    <div class="login-form position-absolute top-50 start-50 translate-middle text-center">
        <h2>Login</h2>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label text-white">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label text-white">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
            </div>
            <button type="submit" class="btn w-100 py-2 mt-3">Login</button>
        </form>
    </div>

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
