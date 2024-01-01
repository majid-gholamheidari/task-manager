<?php

namespace Database\Seeders;

use App\Models\AccessLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accessLevels = [
            [
                'title' => 'RO',
                'description' => 'Access to view own tasks.'
            ],
            [
                'title' => 'RA',
                'description' => 'Access to view all tasks.'
            ],
            [
                'title' => 'CO',
                'description' => 'Access to change own tasks.'
            ],
            [
                'title' => 'CA',
                'description' => 'Access to change all tasks.'
            ],
            [
                'title' => 'AM',
                'description' => 'Access to create new member.'
            ],
            [
                'title' => 'VM',
                'description' => 'Access to list of members.'
            ],
            [
                'title' => 'COT',
                'description' => 'Access to create new task for own.'
            ],
            [
                'title' => 'CAT',
                'description' => 'Access to create new task for any member.'
            ],
            [
                'title' => 'UOT',
                'description' => 'Access to update any task of own.'
            ],
            [
                'title' => 'UAT',
                'description' => 'Access to update any task for any member.'
            ],
            [
                'title' => 'CT',
                'description' => 'Access to create new task.'
            ],
            [
                'title' => 'UB',
                'description' => 'Access update board information.'
            ],
            [
                'title' => 'DM',
                'description' => 'Access to disable member of the board.'
            ]
        ];

        foreach ($accessLevels as $accessLevel)
            AccessLevel::updateOrCreate(['title' => $accessLevel['title']], $accessLevel);
    }
}
