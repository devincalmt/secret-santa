<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pick a User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f1f1;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .blinking-text {
            color: #ff3b3f;
            font-weight: bold;
            font-size: 1.5rem;
            animation: blink 1s step-start infinite;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
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
            color: #006400;
        }

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
            background: linear-gradient(to right, #ff3b3f, #ff6347, #ff4500);
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

        #wishlistFormSection {
            background-color: #e9f5db;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-danger {
            background-color: #ff6347;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        /* Loading Screen Styles */
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Transparent black background */
            display: none; /* Hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Ensure it's on top */
        }

        .loading-circle {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #28a745;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .is-invalid {
            border: 2px solid red;  /* Memberikan border merah pada input yang kosong */
        }

        .wishlist-section {
            display: none; /* Hidden initially */
        }

        #wishlistFormSection .btn-primary {
            display: block;
            margin: 0 auto; /* Membuat tombol berada di tengah */
        }

    </style>
</head>
<body>

<!-- Christmas Background Music -->
<audio autoplay loop class="music-player">
    <source src="{{ asset('audio/jingle-bell.mp3') }}" type="audio/mp3">
    Your browser does not support the audio element.
</audio>

<div class="container mt-5">
    <a href="#myWish" class="blinking-text">
        <p><strong>Jangan lupa untuk mengisi keinginanmu di halaman bawah</strong></p>
    </a>

    <div class="text-center mt-4 selected-user" id="selectedUser">
        Selamat! Kamu akan menjadi santa untuk...
    </div>

    <div class="roulette-box mt-4">
        <div id="rouletteContainer"></div>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-primary" id="startRoulette">Cari Tahu Sekarang!</button>
    </div>

    <div class="wishlist-section mt-4 text-center" id="wishlistSection">
        <h5>{{$receiverName}} Wishlist</h5>
        <div id="wishlistContainer" class="d-inline-block mb-3">
        </div>
        <form action="{{ route('remind-to-fill') }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ $loggedInUser->id }}">
            <button id="remindButton" class="btn btn-secondary" style="display: none;">
                Ingatkan mereka untuk memutuskan!<br> (Identitas mu dirahasiakan)
            </button>
        </form>
    </div>

    <div class="separator-container mt-5" id="myWish">
        <div class="separator"></div>
        <span class="separator-text">Infokan Santa Keinginanmu! </span>
    </div>

    <div class="mt-4" id="wishlistFormSection">
        <h5 class="text-center">My Wishlist</h5>
        <form id="wishlistForm">
            <table class="table table-bordered bg-white">
                <thead>
                    <tr>
                        <th>Barang yang diinginkan</th>
                        <th>Referensi link barang atau online shop</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="wishlistTableBody">
                    @forelse($myWishlists as $wishlist)
                        <tr>
                            <td><input type="text" class="form-control" name="itemName[]" value="{{ $wishlist->title }}" required></td>
                            <td><input type="url" class="form-control" name="itemLink[]" value="{{ $wishlist->link }}" required></td>
                            <td><button type="button" class="btn btn-danger remove-item">Hapus</button></td>
                        </tr>
                    @empty
                        <tr>
                            <td><input type="text" class="form-control" name="itemName[]" required></td>
                            <td><input type="url" class="form-control" name="itemLink[]" required></td>
                            <td><button type="button" class="btn btn-danger remove-item">Hapus</button></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <button type="button" class="btn btn-success" id="addWishlistItem">Tambah Barang</button>
            <br><br>
            <button type="submit" class="btn btn-primary" id="saveWishlist">Simpan dan beritahu santa!</button>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay">
    <div class="loading-circle"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        var users = @json($users->pluck('name')); 
        var receiverName = "{{ $receiverName }}"; 
        var receiverWishlist = @json($receiverWishlist);
        var rouletteContainer = $('#rouletteContainer');
        var wishlistContainer = $('#wishlistContainer');
        var remindButton = $('#remindButton');
        var wishlistFormSection = $('#wishlistFormSection');
        var wishlistTableBody = $('#wishlistTableBody');
        var loadingOverlay = $('#loadingOverlay');

        rouletteContainer.html('<div class="roulette-item">???</div>');

        function displayWishlist() {
            if (receiverWishlist.length === 0) {
                wishlistContainer.html(`<p>${receiverName} belum memutuskan apa yang mereka inginkan.</p>`);
                remindButton.show();
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
                remindButton.hide();
            }
        }
        displayWishlist();

        function showWishlistForm() {
            wishlistFormSection.show();
        }

        function shuffle(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
        }
        shuffle(users);

        $('#startRoulette').on('click', function() {
            let audio = new Audio('/audio/roulette-spin.mp3.wav');
            audio.play().catch(function(error) {
                console.error('Audio playback prevented:', error);
            });

            let index = 0;
            const totalSpins = 30; 
            const interval = 100; 
            let progress = 0;

            const intervalId = setInterval(() => {
                $('#rouletteContainer').html('<div class="roulette-item">' + users[index] + '</div>');
                index = (index + 1) % users.length; 
            }, interval);

            setTimeout(() => {
                clearInterval(intervalId);
                $('#rouletteContainer').html('<div class="roulette-item">' + receiverName + '</div>');
                audio.pause(); 
                audio.currentTime = 0;

                $('#startRoulette').hide();
                showWishlistForm();
                $('#wishlistSection').show(); 
            }, totalSpins * interval);
        });

        $('#saveWishlist').on('click', function(e) {
            e.preventDefault(); // Prevent form submission for now
            loadingOverlay.show(); // Show loading overlay

            let isValid = true;

            // Memeriksa setiap input itemName apakah kosong
            $('input[name="itemName[]"]').each(function() {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');  // Memberikan class invalid pada input yang kosong
                } else {
                    $(this).removeClass('is-invalid'); // Menghapus class invalid jika input terisi
                }
            });

            if (!isValid) {
                loadingOverlay.hide();
                return
            }

            // Prepare the data to be sent in the AJAX request
            var formData = {
                user_id: "{{ $loggedInUser->id }}", // user ID from backend
                itemName: [], // Array to hold the item names
                itemLink: []  // Array to hold the item links
                
            };

            // Gather item names and links from the form
            $('#wishlistTableBody tr').each(function() {
                var itemName = $(this).find('input[name="itemName[]"]').val();
                var itemLink = $(this).find('input[name="itemLink[]"]').val();

                formData.itemName.push(itemName);
                formData.itemLink.push(itemLink);
            });

            // Send the AJAX request
            $.ajax({
                url: "{{ route('add-my-wishlist') }}",  // The route for adding wishlist
                method: 'POST',
                data: {
                    ...formData,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    loadingOverlay.hide(); // Hide loading overlay after request completes
                    location.reload(true)
                },
                error: function(xhr, status, error) {
                    loadingOverlay.hide(); // Hide loading overlay if there is an error
                    alert('Terjadi kesalahan saat menyimpan wishlist!');
                }
            });
        });

        $('#addWishlistItem').on('click', function() {
            var itemRow = `
                <tr>
                    <td><input type="text" class="form-control" name="itemName[]"></td>
                    <td><input type="url" class="form-control" name="itemLink[]"></td>
                    <td><button type="button" class="btn btn-danger remove-item">Hapus</button></td>
                </tr>
            `;
            wishlistTableBody.append(itemRow);
        });

        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
        });
    });

    window.addEventListener('scroll', function() {
        var audio = document.getElementById('christmas-music');
        audio.play().catch(function(error) {
            console.log("Autoplay blocked. User interaction required.");
        });
    });
</script>

</body>
</html>
