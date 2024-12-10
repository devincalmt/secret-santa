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

        .wishlist-section {
            display: none; /* Hidden initially */
        }

        /* Blinking Text Style */
        .blinking-text {
            color: red;
            font-weight: bold;
            font-size: 1.5rem;
            animation: blink 1s step-start infinite;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
        }

        /* Blinking animation */
        @keyframes blink {
            50% {
                opacity: 0;
            }
        }

        /* Pemisah Cantik */
        .separator-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            position: relative;
        }

        .separator {
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, #ff7f50, #ff6347, #ff4500);
            border: none;
            border-radius: 5px;
        }

        .separator-text {
            position: absolute;
            background: #fff;
            padding: 0 10px;
            font-weight: bold;
            color: #ff4500;
            font-size: 1.25rem;
            z-index: 1;
        }

        #wishlistFormSection .btn-primary {
            display: block;
            margin: 0 auto; /* Membuat tombol berada di tengah */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Message to fill wishlist with blinking effect -->
    <a href="#myWish" class="blinking-text">
        <p><strong>Jangan lupa untuk mengisi keinginanmu di halaman bawah</strong></p>
    </a>

    <!-- Selected User Display -->
    <div class="text-center mt-4 selected-user" id="selectedUser">
        Selamat! Kamu akan menjadi santa untuk...
    </div>

    <!-- Roulette Animation Box -->
    <div class="roulette-box mt-4">
        <div id="rouletteContainer"></div>
    </div>

    <!-- Button to Start the Roulette -->
    <div class="text-center mt-4">
        <button class="btn btn-primary" id="startRoulette">Cari Tahu Sekarang!</button>
    </div>

    <!-- Wishlist Section for Friend (Initially Hidden) -->
    <div class="wishlist-section mt-4 text-center" id="wishlistSection">
        <h5>{{$receiverName}} Wishlist</h5>
        <div id="wishlistContainer" class="d-inline-block mb-3">
            <!-- Wishlist or fallback text will be dynamically inserted here -->
        </div>
        <form action="" method="post">
            <button id="remindButton" class="btn btn-secondary" style="display: none;">
                Ingatkan mereka untuk memutuskan!<br> (identitas mu dirahasiakan)
            </button>
        </form>
    </div>

    <!-- Pemisah Cantik -->
    <div class="separator-container mt-5" id="myWish">
        <div class="separator"></div>
        <span class="separator-text">Infokan Santa Keinginanmu</span>
    </div>

    <!-- Wishlist Form Section (for your wishlist) -->
    <div class="mt-4" id="wishlistFormSection">
        <h5 class="text-center">My Wishlist</h5>
        <form id="wishlistForm">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Barang yang diinginkan</th>
                        <th>Referensi link barang atau online shop</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="wishlistTableBody">
                    <!-- Default row with empty inputs -->
                    <tr>
                        <td><input type="text" class="form-control" name="itemName[]" required></td>
                        <td><input type="url" class="form-control" name="itemLink[]" required></td>
                        <td><button type="button" class="btn btn-danger remove-item">Hapus</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-success" id="addWishlistItem">Tambah Barang</button>
            <br><br>
            <button type="submit" class="btn btn-primary" id="saveWishlist">Simpan dan beritahu santa!</button>
        </form>
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
        var wishlistFormSection = $('#wishlistFormSection');
        var wishlistTableBody = $('#wishlistTableBody');

        // Wishlist data array
        var wishlistData = [];

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

        // Show the wishlist form section after roulette ends
        function showWishlistForm() {
            wishlistFormSection.show();
        }

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

                // Hide the Start Roulette button after the spin ends
                $('#startRoulette').hide(); 

                // Show wishlist form after roulette is done
                showWishlistForm();
                $('#wishlistSection').show(); // Show the friend's wishlist section
            }, totalSpins * interval);

        });

        // Add new item to wishlist
        $('#addWishlistItem').on('click', function() {
            var itemRow = `
                <tr>
                    <td><input type="text" class="form-control" name="itemName[]" required></td>
                    <td><input type="url" class="form-control" name="itemLink[]" required></td>
                    <td><button type="button" class="btn btn-danger remove-item">Hapus</button></td>
                </tr>
            `;
            wishlistTableBody.append(itemRow);
        });

        // Remove item from wishlist
        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
        });

        // Save wishlist
        $('#wishlistForm').on('submit', function(event) {
            event.preventDefault();

            // Get all the item names and links
            var itemNames = $("input[name='itemName[]']").map(function() {
                return $(this).val();
            }).get();

            var itemLinks = $("input[name='itemLink[]']").map(function() {
                return $(this).val();
            }).get();

            // Combine them into an array of objects
            wishlistData = itemNames.map(function(name, index) {
                return { name: name, link: itemLinks[index] };
            });

            // You can use wishlistData to send the data to your server or display it
            console.log(wishlistData);

            // Display wishlist
            displayWishlist();
        });
    });
</script>

</body>
</html>
