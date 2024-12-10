<?php

namespace App\Http\Controllers;

use App\Models\SecretSanta;
use App\Models\UserDetail;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    protected $fonnteController;

    public function __construct(FonnteController $fonnteController)
    {
        $this->fonnteController = $fonnteController;
    }

    public function addMyWishlist(Request $request)
    {
        // Validate the input to ensure there are no empty values in the arrays
        $request->validate([
            'itemName' => 'required|array',
            'itemLink' => 'required|array',
            'itemName.*' => 'required|string|max:255'
        ]);

        // Ensure both arrays are of the same length
        if (count($request->itemName) !== count($request->itemLink)) {
            return redirect()->back()->withErrors('The item names and links must match.');
        }

        // Get the user_id from the request
        $user_id = $request->input('user_id');

        $secretSanta = SecretSanta::where('receiver_id', $user_id)->first();
        $receiver = $secretSanta->receiver;
        $giver = $secretSanta->giver;
        $giverPhoneNumbers = $giver->userDetails->pluck('phone_number')->toArray();

        $alreadySent = false;

        $wishlistTemp = Wishlist::where('user_id', $user_id);
        if ($wishlistTemp->count() > 0) {
            $wishlistTemp->delete();
            $alreadySent = true;
        }

        $newWishlists = [];

        // Insert data into the Wishlist table
        foreach ($request->itemName as $index => $title) {
            $link = $request->itemLink[$index];
            $newWishlists[] = [
                'title' => $title,
                'link' => $link
            ];

            Wishlist::create([
                'user_id' => $user_id,
                'title' => $title,
                'link' => $link,
            ]);
        }

        foreach ($giverPhoneNumbers as $phoneNumber) {
            $newOrNo = $alreadySent ? "ingin update" : "ingin bilang";
            $text = "Halo *{$giver->name}* 👋,\n\n".
                "*{$receiver->name}* $newOrNo bahwa dia sangat ingin barang-barang berikut saat Christmas Party tanggal 14 Desember nanti!🥹\n\n";

            foreach ($newWishlists as $newWishlist) {
                $text .= "- {$newWishlist['title']} {$newWishlist['link']}\n";
            }

            $text .= "\nTolong kabulkan permintaannya ya🫶\n\nTerima kasih🎉";

            $this->fonnteController->sendFonnteMessage($phoneNumber, $text);
        }

        // Redirect back to the user's wishlist page
        return redirect()->route('dashboard', ['id' => $user_id]);
    }

    public function remindToFill(Request $request) {
        $secretSanta = SecretSanta::where('giver_id', $request->user_id)->first();
        $receiver = $secretSanta->receiver;

        $receiverPhoneNumber = $receiver->userDetails->pluck('phone_number')->toArray();

        foreach ($receiverPhoneNumber as $phoneNumber) {
            $url = env('APP_URL');

            $text = "Halo *{$receiver->name}* 👋,\n\n".
                "Jangan lupa untuk mengisi permintaanmu di link berikut ya karena santa-mu sedang menanti🤭\n\n".
                "$url\n\n".
                "Jangan lupa bahwa kode mu adalah: *$receiver->code*\n\n".
                "Terima kasih🫶";

            $this->fonnteController->sendFonnteMessage($phoneNumber, $text);
        }

        return redirect()->back();
    }
}
