<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pick a User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .wishlist-section table {
            margin: 0 auto; /* Center the table horizontally */
        }

        .roulette-box {
            width: 300px;
            height: 50px;
            margin: 50px auto;
            border: 2px solid #333;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }

        .roulette-item {
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }

        .selected-user {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Selected User Display -->
    <div class="text-center mt-4 selected-user" id="selectedUser">
        Selamat! Kamu akan menjadi santa untuk...
    </div>

    <!-- Roulette Animation Box -->
    <div class="roulette-box mt-4">
        <div id="rouletteContainer"></div>
    </div>

    <!-- Wishlist Section -->
    <div class="wishlist-section mt-4 text-center" id="wishlistSection" style="display: none;">
        <h5>{{$receiverName}} Wishlist</h5>
        <div id="wishlistContainer" class="d-inline-block mb-3">
            <!-- Wishlist or fallback text will be dynamically inserted here -->
        </div>
        <form action="" method="post">
            <button id="remindButton" class="btn btn-secondary" style="display: none;">
                Ingatkan mereka untuk memutuskan!<br> (Identitas mu dirahasiakan)
            </button>
        </form>
    </div>

    <!-- Button to Start the Roulette -->
    <div class="text-center mt-4">
        <button class="btn btn-primary" id="startRoulette">Cari Tau Sekarang!</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Define variables
        var users = @json($users->pluck('name')); // Laravel passes user names as a JavaScript array
        var receiverName = "{{ $receiverName }}"; // Correctly passed from Laravel
        var receiverWishlist = @json($receiverWishlist); // Assume this is an array of items
        var rouletteContainer = $('#rouletteContainer');
        var wishlistContainer = $('#wishlistContainer');
        var remindButton = $('#remindButton');
        var wishlistSection = $('#wishlistSection');
        var startRouletteButton = $('#startRoulette');

        // Initialize roulette container with ???
        rouletteContainer.html('<div class="roulette-item">???</div>');

        // Display Wishlist or Fallback
        function displayWishlist() {
            if (receiverWishlist.length === 0) {
                wishlistContainer.html(`<p>${receiverName} belum memutuskan apa yang mereka inginkan.</p>`);
                remindButton.show(); // Show the remind button
            } else {
                let tableHtml = `
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                receiverWishlist.forEach(item => {
                    tableHtml += `
                        <tr>
                            <td>${item.title}</td>
                            <td><a href="${item.link}" target="_blank">${item.link}</a></td>
                        </tr>
                    `;
                });

                tableHtml += `
                        </tbody>
                    </table>
                `;

                wishlistContainer.html(tableHtml);
                remindButton.hide(); // Hide the remind button
            }
        }
        displayWishlist();

        // Shuffle users for visual randomness
        function shuffle(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
        }
        shuffle(users);

        // Roulette logic
        $('#startRoulette').on('click', function() {
            let audio = new Audio('/audio/roulette-spin.mp3.wav'); // Ensure correct path to your audio file

            // Try playing the audio
            audio.play().catch(function(error) {
                console.error('Audio playback prevented:', error);
            });

            // Start the roulette animation
            let index = 0;
            const totalSpins = 30; // Number of spins before stopping
            const interval = 100; // Speed of rotation in milliseconds

            const intervalId = setInterval(() => {
                // Display the current user
                $('#rouletteContainer').html('<div class="roulette-item">' + users[index] + '</div>');
                index = (index + 1) % users.length; // Loop through users
            }, interval);

            setTimeout(() => {
                clearInterval(intervalId); // Stop the rotation
                $('#rouletteContainer').html('<div class="roulette-item">' + receiverName + '</div>');                
                audio.pause(); // Stop the audio
                audio.currentTime = 0; // Reset audio position
                
                // Show the wishlist section and hide the roulette button
                wishlistSection.show();
                startRouletteButton.hide();
            }, totalSpins * interval);
        });
    });
</script>

</body>
</html>
