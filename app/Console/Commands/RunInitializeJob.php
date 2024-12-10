<?php

namespace App\Console\Commands;

use App\Http\Controllers\FonnteController;
use App\Models\User;
use Illuminate\Console\Command;

class RunInitializeJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $fonnteController;

    /**
     * Create a new command instance.
     */
    public function __construct(FonnteController $fonnteController)
    {
        parent::__construct();
        $this->fonnteController = $fonnteController;
    }

    /**
     * Execute the command.
     */
    public function handle(): void
    {
        $users = User::with('userDetails')->get();
        foreach ($users as $user) {
            foreach ($user->userDetails as $detail) {
                $text = "Halo *{$user->name}*,\n\n".
                    "Selamat datang ke secret santa LG JGC\n\n".
                    "Berikut adalah kode kamu: *{$user->code}* (Untuk verifikasi)\n\n".
                    "Silakan menuju ke link dibawah ini untuk melihat siapa orang yang akan menerima hadiah dari kamu dan kasih tau apa yang kamu mau ke santa mu <3\n\n".
                    "_{ini link}_\n\n".
                    "Made with love from devinca <3";
                    
                $this->fonnteController->sendFonnteMessage($detail->phone_number, $text);
            }
        }

        $this->info('Finished');
    }
}
