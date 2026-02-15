<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TraditionCategory;
use App\Models\Tradition;
use App\Models\User;

class TraditionSeeder extends Seeder
{
    public function run(): void
    {
        // Create a default user if none exists
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@msomiclan.com',
                'password' => bcrypt('password'),
                'language_preference' => 'sw',
            ]);
        }

        // Create tradition categories
        $categories = [
            [
                'name_sw' => 'Sherehe za Jadi',
                'name_en' => 'Traditional Ceremonies',
                'description_sw' => 'Sherehe mbalimbali za kitamaduni',
                'description_en' => 'Various cultural ceremonies',
                'icon' => '🎭',
                'color' => '#8B5CF6',
            ],
            [
                'name_sw' => 'Ngoma na Muziki',
                'name_en' => 'Dance and Music',
                'description_sw' => 'Ngoma na nyimbo za asili',
                'description_en' => 'Traditional dances and songs',
                'icon' => '🥁',
                'color' => '#EC4899',
            ],
            [
                'name_sw' => 'Mavazi ya Jadi',
                'name_en' => 'Traditional Attire',
                'description_sw' => 'Nguo na mapambo ya kitamaduni',
                'description_en' => 'Cultural clothing and ornaments',
                'icon' => '👘',
                'color' => '#F59E0B',
            ],
            [
                'name_sw' => 'Vyakula vya Asili',
                'name_en' => 'Traditional Foods',
                'description_sw' => 'Chakula na vinywaji vya jadi',
                'description_en' => 'Traditional foods and beverages',
                'icon' => '🍲',
                'color' => '#10B981',
            ],
        ];

        foreach ($categories as $categoryData) {
            TraditionCategory::create($categoryData);
        }

        // Create sample traditions
        $traditions = [
            [
                'category_id' => 1,
                'title_sw' => 'Sherehe ya Harusi ya Kijita',
                'title_en' => 'Jita Traditional Wedding',
                'description_sw' => 'Harusi ya kijita ni sherehe kubwa inayohusisha jamii nzima. Inajumuisha desturi mbalimbali za kipekee.',
                'description_en' => 'The Jita traditional wedding is a grand celebration involving the entire community with unique customs.',
                'content_sw' => 'Harusi ya kijita ni moja ya sherehe kubwa zaidi katika jamii ya Wajita. Sherehe hii inachukua siku kadhaa na inahusisha jamii nzima. Desturi za harusi ni pamoja na mahari, ibada za jadi, ngoma, na karamu kubwa.',
                'content_en' => 'The Jita traditional wedding is one of the grandest celebrations in the Jita community. This ceremony takes several days and involves the entire community. Wedding customs include bride price, traditional rituals, dances, and a grand feast.',
                'status' => 'published',
                'views_count' => 245,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'category_id' => 2,
                'title_sw' => 'Ngoma ya Ekyembe',
                'title_en' => 'Ekyembe Dance',
                'description_sw' => 'Ngoma ya Ekyembe ni ngoma ya jadi inayochezwa wakati wa sherehe za maadhimisho.',
                'description_en' => 'The Ekyembe dance is a traditional dance performed during celebration ceremonies.',
                'content_sw' => 'Ngoma ya Ekyembe ni mojawapo ya ngoma za asili za Wajita. Ngoma hii inachezwa na wanaume na wanawake wakiwa wamevaa mavazi ya jadi. Inachukuliwa kuwa ngoma ya furaha na maadhimisho.',
                'content_en' => 'The Ekyembe dance is one of the original Jita dances. This dance is performed by both men and women wearing traditional attire. It is considered a dance of joy and celebration.',
                'status' => 'published',
                'views_count' => 189,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'category_id' => 3,
                'title_sw' => 'Ekitambi - Nguo ya Wanawake',
                'title_en' => 'Ekitambi - Women\'s Traditional Dress',
                'description_sw' => 'Ekitambi ni nguo ya jadi inayovaliwa na wanawake wa Kijita wakati wa matukio maalum.',
                'description_en' => 'Ekitambi is traditional attire worn by Jita women during special occasions.',
                'content_sw' => 'Ekitambi ni nguo ya rangi mbalimbali yenye mapambo ya kipekee. Nguo hii huvaliwa na wanawake wakati wa sherehe za harusi, maadhimisho, na matukio mengine muhimu ya kijamii.',
                'content_en' => 'Ekitambi is a colorful garment with unique decorations. This dress is worn by women during weddings, celebrations, and other important social events.',
                'status' => 'published',
                'views_count' => 156,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'category_id' => 4,
                'title_sw' => 'Obusuma - Ugali wa Wimbi',
                'title_en' => 'Obusuma - Millet Ugali',
                'description_sw' => 'Obusuma ni chakula cha jadi kinachotengenezwa kwa unga wa wimbi.',
                'description_en' => 'Obusuma is a traditional food made from millet flour.',
                'content_sw' => 'Obusuma ni chakula kikuu cha Wajita kinachotengenezwa kwa unga wa wimbi. Kinaliwa na mboga mbalimbali, samaki, au nyama. Ni chakula chenye virutubisho vingi na ni sehemu muhimu ya utamaduni wa Wajita.',
                'content_en' => 'Obusuma is a staple food of the Jita people made from millet flour. It is eaten with various vegetables, fish, or meat. It is a nutritious food and an important part of Jita culture.',
                'status' => 'published',
                'views_count' => 312,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'category_id' => 1,
                'title_sw' => 'Sherehe ya Jando',
                'title_en' => 'Coming of Age Ceremony',
                'description_sw' => 'Sherehe ya kuingia utu uzima kwa vijana wa kiume.',
                'description_en' => 'A ceremony marking the transition to adulthood for young men.',
                'content_sw' => 'Sherehe ya Jando ni moja ya desturi muhimu zaidi katika jamii ya Wajita. Sherehe hii inaashiria mwanzo wa utu uzima kwa vijana wa kiume. Inajumuisha mafundisho ya maadili, historia ya jamii, na majukumu ya mtu mzima.',
                'content_en' => 'The Jando ceremony is one of the most important traditions in the Jita community. This ceremony marks the beginning of adulthood for young men. It includes teachings on morals, community history, and adult responsibilities.',
                'status' => 'published',
                'views_count' => 278,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'category_id' => 2,
                'title_sw' => 'Nyimbo za Jadi',
                'title_en' => 'Traditional Songs',
                'description_sw' => 'Nyimbo za asili zinazoimba wakati wa sherehe na matukio.',
                'description_en' => 'Original songs sung during ceremonies and events.',
                'content_sw' => 'Nyimbo za jadi za Wajita ni hazina ya utamaduni. Nyimbo hizi zinasimulia historia, mafundisho, na uzoefu wa jamii. Zinaimbwa wakati wa sherehe, kazi za mashambani, na matukio ya kijamii.',
                'content_en' => 'Traditional Jita songs are a cultural treasure. These songs tell stories, teachings, and community experiences. They are sung during ceremonies, farm work, and social events.',
                'status' => 'published',
                'views_count' => 198,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
        ];

        foreach ($traditions as $traditionData) {
            Tradition::create($traditionData);
        }
    }
}
