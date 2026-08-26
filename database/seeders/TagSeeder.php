<?php

namespace Database\Seeders;

use App\Enums\TagName;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        foreach (TagName::cases() as $tag) {
            Tag::firstOrCreate(['name' => $tag->value]);
        }
    }
}
