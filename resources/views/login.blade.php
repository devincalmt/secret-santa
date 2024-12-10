<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Christmas Party</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4; /* Light background */
            font-family: 'Arial', sans-serif;
            overflow: hidden;
            color: #fff;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            position: relative;
            z-index: 1;
        }
        h2 {
            color: #d32f2f; /* Christmas red */
        }
        .btn-primary {
            background-color: #388e3c; /* Christmas green */
            border: none;
        }
        .btn-primary:hover {
            background-color: #2e7d32; /* Darker green on hover */
        }
        .form-select {
            border-color: #388e3c; /* Green border for select */
        }
        .form-control {
            border-color: #388e3c;
        }
        .alert {
            color: #d32f2f;
            background-color: #fff3e0; /* Light yellow background for errors */
            border: 1px solid #d32f2f;
        }
        /* Snow animation */
        .snowflake {
            position: absolute;
            top: -10px;
            color: #b3e0ff; /* Light bluish color for snowflakes */
            font-size: 1.5em;
            z-index: 10;
            pointer-events: none;
            animation: fall linear infinite;
            border-radius: 50%;
            width: 10px;
            height: 10px;
            background-color: #b3e0ff; /* Light bluish snowflakes */
        }
        @keyframes fall {
            to {
                transform: translateY(100vh);
            }
        }
        .music-player {
            position: fixed;
            bottom: 10px;
            right: 10px;
            z-index: 100;
        }
    </style>
</head>
<body>

<!-- Christmas Background Music -->
<audio autoplay loop class="music-player">
    <source src="{{ asset('audio/jingle-bell.mp3') }}" type="audio/mp3">
    Your browser does not support the audio element.
</audio>

<!-- Snow Animation -->
<div class="snowflakes">
    <div class="snowflake" style="left: 5%; animation-duration: 3s; animation-delay: 0s;"></div>
    <div class="snowflake" style="left: 10%; animation-duration: 4s; animation-delay: 1s;"></div>
    <div class="snowflake" style="left: 15%; animation-duration: 2.5s; animation-delay: 0.5s;"></div>
    <div class="snowflake" style="left: 20%; animation-duration: 5s; animation-delay: 2s;"></div>
    <div class="snowflake" style="left: 25%; animation-duration: 3.5s; animation-delay: 0.3s;"></div>
    <div class="snowflake" style="left: 30%; animation-duration: 4.5s; animation-delay: 1.5s;"></div>
    <div class="snowflake" style="left: 35%; animation-duration: 2.8s; animation-delay: 3s;"></div>
    <div class="snowflake" style="left: 40%; animation-duration: 3.2s; animation-delay: 2.2s;"></div>
    <div class="snowflake" style="left: 45%; animation-duration: 4s; animation-delay: 1.8s;"></div>
    <div class="snowflake" style="left: 50%; animation-duration: 5s; animation-delay: 0.8s;"></div>
    <div class="snowflake" style="left: 55%; animation-duration: 2.5s; animation-delay: 3.5s;"></div>
    <div class="snowflake" style="left: 60%; animation-duration: 3.7s; animation-delay: 2.6s;"></div>
    <div class="snowflake" style="left: 65%; animation-duration: 4.2s; animation-delay: 1s;"></div>
    <div class="snowflake" style="left: 70%; animation-duration: 3s; animation-delay: 2.3s;"></div>
    <div class="snowflake" style="left: 75%; animation-duration: 5s; animation-delay: 4.5s;"></div>
    <div class="snowflake" style="left: 80%; animation-duration: 4s; animation-delay: 0.7s;"></div>
    <div class="snowflake" style="left: 85%; animation-duration: 3.6s; animation-delay: 1.4s;"></div>
    <div class="snowflake" style="left: 90%; animation-duration: 4.5s; animation-delay: 2.9s;"></div>
    <div class="snowflake" style="left: 95%; animation-duration: 3.8s; animation-delay: 0.6s;"></div>
</div>

<div class="container mt-5">
    <h2 class="text-center">Christmas Party</h2>
    <h2 class="text-center">LG JGC - Jesus Goes to Cakung</h2>
    <br>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <select name="name" id="name" class="form-select">
                <option value="" disabled selected>Siapa kamu?</option>
                @foreach ($users as $user)
                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <input type="text" name="code" id="code" class="form-control" placeholder="Masukan kode mu (Dari whatsapp)" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Mari kita mulai!</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
    window.addEventListener('scroll', function() {
        var audio = document.getElementById('christmas-music');
        audio.play().catch(function(error) {
            console.log("Autoplay blocked. User interaction required.");
        });
    });
</script>

</body>
</html>
