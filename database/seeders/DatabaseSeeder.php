<?php

namespace Database\Seeders;

use App\Models\SecretSanta;
use App\Models\User;
use App\Models\UserDetail;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $users = [
        //     [
        //         'name' => 'Adit Bella',
        //         'details' => [
        //             ['phone_number' => '6281806059058'],
        //             ['phone_number' => '6281913218896']
        //         ]
        //     ],
        //     [
        //         'name' => 'Adry Corin',
        //         'details' => [
        //             ['phone_number' => '6281287770109'],
        //             ['phone_number' => '6281260600109']
        //         ]
        //     ],
        //     [
        //         'name' => 'Aldo Dyana',
        //         'details' => [
        //             ['phone_number' => '6281212092737'],
        //             ['phone_number' => '6281519919917']
        //         ]
        //     ],
        //     [
        //         'name' => 'David Devinca',
        //         'details' => [
        //             ['phone_number' => '6285171551704'],
        //             ['phone_number' => '628886333812']
        //         ]
        //     ],
        //     [
        //         'name' => 'Edward Regina',
        //         'details' => [
        //             ['phone_number' => '6281908960859'],
        //             ['phone_number' => '6287785044222']
        //         ]
        //     ],
        //     [
        //         'name' => 'Meiliana',
        //         'details' => [
        //             ['phone_number' => '6287780519170']
        //         ]
        //     ],
        //     [
        //         'name' => 'Mitha Ferdi',
        //         'details' => [
        //             ['phone_number' => '6281806270088']
        //         ]
        //     ],
        //     [
        //         'name' => 'JJ',
        //         'details' => [
        //             ['phone_number' => '6281586215559'],
        //             ['phone_number' => '6281808600700']
        //         ]
        //     ]
        // ];

        $users = [
            [
                'name' => 'Devinca',
                'details' => [
                    ['phone_number' => '6285171551704']
                ]
            ],
            [
                'name' => 'David',
                'details' => [
                    ['phone_number' => '628886333812']
                ]
            ],
            [
                'name' => 'Adit',
                'details' => [
                    ['phone_number' => '628886333812']
                ]
            ],
            [
                'name' => 'Edward',
                'details' => [
                    ['phone_number' => '628886333812']
                ]
            ],
            [
                'name' => 'Regina',
                'details' => [
                    ['phone_number' => '628886333812']
                ]
            ],
            [
                'name' => 'Pacis',
                'details' => [
                    ['phone_number' => '628886333812']
                ]
            ],
            [
                'name' => 'Halo',
                'details' => [
                    ['phone_number' => '628886333812']
                ]
            ]
        ];

        foreach ($users as $user) {
            $newU = User::create(['name' => $user['name'], 'code' => Str::random(6)]);
            foreach ($user['details'] as $userDetail) {
                UserDetail::create(['user_id' => $newU->id, 'phone_number' => $userDetail['phone_number']]);
            }
        }

        // Secret Santa
        $users = User::all()->pluck('id')->toArray();

        if (count($users) > 1) {
            shuffle($users);

            for ($i = 0; $i < count($users); $i++) {
                $giver_id = $users[$i];
                
                $receiver_id = $users[($i + 1) % count($users)];

                SecretSanta::create([
                    'giver_id' => $giver_id,
                    'receiver_id' => $receiver_id,
                ]);
            }
        }
    }
}
