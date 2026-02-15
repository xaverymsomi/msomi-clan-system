<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@msomiclan.com',
                'password' => bcrypt('password'),
                'language_preference' => 'sw',
            ]);
        }

        $events = [
            [
                'title_sw' => 'Mkutano Mkuu wa Ukoo 2026',
                'title_en' => 'Annual Clan Gathering 2026',
                'description_sw' => 'Mkutano wa kila mwaka wa wanachama wote wa ukoo wa Msomi. Tutajadili maendeleo ya ukoo na kupanga mipango ya baadaye.',
                'description_en' => 'Annual meeting of all Msomi clan members. We will discuss clan progress and plan for the future.',
                'event_type' => 'meeting',
                'start_date' => Carbon::now()->addDays(15)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(15)->setTime(17, 0),
                'location' => 'Mwanza, Tanzania',
                'venue' => 'Msomi Community Hall',
                'max_attendees' => 200,
                'created_by' => $user->id,
            ],
            [
                'title_sw' => 'Sherehe ya Maadhimisho ya Miaka 50',
                'title_en' => '50th Anniversary Celebration',
                'description_sw' => 'Tunasherehekea miaka 50 ya kuanzishwa kwa chama cha ukoo wa Msomi. Sherehe kubwa ikijumuisha ngoma, vyakula, na zawadi.',
                'description_en' => 'Celebrating 50 years since the founding of the Msomi clan association. Grand celebration including dances, food, and prizes.',
                'event_type' => 'celebration',
                'start_date' => Carbon::now()->addDays(45)->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(45)->setTime(22, 0),
                'location' => 'Musoma, Tanzania',
                'venue' => 'Musoma Cultural Center',
                'max_attendees' => 500,
                'created_by' => $user->id,
            ],
            [
                'title_sw' => 'Warsha ya Mila na Desturi kwa Vijana',
                'title_en' => 'Youth Cultural Workshop',
                'description_sw' => 'Warsha maalum ya kufundisha vijana kuhusu mila na desturi za Wajita. Itajumuisha ngoma, nyimbo, na hadithi za jadi.',
                'description_en' => 'Special workshop to teach youth about Jita customs and traditions. Will include dances, songs, and traditional stories.',
                'event_type' => 'other',
                'start_date' => Carbon::now()->addDays(30)->setTime(14, 0),
                'end_date' => Carbon::now()->addDays(30)->setTime(18, 0),
                'location' => 'Mwanza, Tanzania',
                'venue' => 'Jita Cultural Center',
                'max_attendees' => 100,
                'created_by' => $user->id,
            ],
            [
                'title_sw' => 'Mkutano wa Wazee wa Ukoo',
                'title_en' => 'Clan Elders Meeting',
                'description_sw' => 'Mkutano wa wazee wa ukoo kujadili masuala muhimu ya jamii na kutoa mwongozo.',
                'description_en' => 'Meeting of clan elders to discuss important community matters and provide guidance.',
                'event_type' => 'meeting',
                'start_date' => Carbon::now()->addDays(7)->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(7)->setTime(15, 0),
                'location' => 'Bukoba, Tanzania',
                'venue' => 'Elders Council Hall',
                'max_attendees' => 50,
                'created_by' => $user->id,
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }
    }
}
