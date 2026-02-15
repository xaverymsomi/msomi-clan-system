<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use Illuminate\Database\Seeder;

class DocumentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_sw' => 'Sheria na Kanuni',
                'name_en' => 'Rules & Regulations',
            ],
            [
                'name_sw' => 'Mkataba',
                'name_en' => 'Agreements',
            ],
            [
                'name_sw' => 'Ripoti za Fedha',
                'name_en' => 'Financial Reports',
            ],
            [
                'name_sw' => 'Mikutano',
                'name_en' => 'Meeting Minutes',
            ],
            [
                'name_sw' => 'Historia ya Ukoo',
                'name_en' => 'Family History',
            ],
            [
                'name_sw' => 'Picha',
                'name_en' => 'Photos',
            ],
            [
                'name_sw' => 'Nyinginezo',
                'name_en' => 'Miscellaneous',
            ],
        ];

        foreach ($categories as $category) {
            DocumentCategory::create($category);
        }
    }
}
