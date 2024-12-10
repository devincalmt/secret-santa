<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Christmas Party</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff; /* Light blue background for a cheerful vibe */
            font-family: 'Arial', sans-serif;
            color: #333;
            overflow: hidden;
            position: relative;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            position: relative;
            z-index: 10; /* Ensures the form is on top of other elements */
        }
        h2 {
            color: #d32f2f; /* Christmas red */
            font-size: 2.5rem;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #388e3c; /* Christmas green */
            border: none;
            padding: 12px 30px;
            font-size: 1.2rem;
            border-radius: 25px;
        }
        .btn-primary:hover {
            background-color: #2e7d32; /* Darker green on hover */
        }
        .form-select, .form-control {
            border-radius: 10px;
            border-color: #388e3c;
            font-size: 1.1rem;
        }
        .alert {
            color: #d32f2f;
            background-color: #ffebee; /* Light pink background for errors */
            border: 1px solid #d32f2f;
        }
        /* Snow animation */
        .snowflake {
            position: absolute;
            top: -10px;
            color: #b3e0ff;
            font-size: 1.5em;
            animation: fall linear infinite;
            border-radius: 50%;
            width: 12px;
            height: 12px;
            background-color: #b3e0ff;
            z-index: 1; /* Lower z-index for snowflakes */
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
        .snowflakes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none; /* Prevents snowflakes from blocking clicks */
        }
    </style>
</head>
<body>

<!-- Christmas Background Music -->
<audio autoplay loop class="music-player" id="christmas-music">
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
</div>

<div class="container mt-5">
    <h2 class="text-center mb-4">🎄 Christmas Party 🎄</h2>
    <h3 class="text-center mb-5">LG JGC - Jesus Goes to Cakung</h3>

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
