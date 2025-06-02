<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Notify;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            ['name' => 'banner read',  'category' => 'Banners'],
            ['name' => 'banner create',  'category' => 'Banners'],
            ['name' => 'banner edit',  'category' => 'Banners'],
            ['name' => 'banner delete',  'category' => 'Banners'],

            ['name' => 'admin read',  'category' => 'Admins'],
            ['name' => 'admin create',  'category' => 'Admins'],
            ['name' => 'admin edit',  'category' => 'Admins'],
            ['name' => 'admin delete',  'category' => 'Admins'],
            ['name' => 'admin send notification'  ,  'category' => 'Admins'],

            ['name' => 'role read',  'category' => 'Roles'],
            ['name' => 'role create',  'category' => 'Roles'],
            ['name' => 'role edit',  'category' => 'Roles'],
            ['name' => 'role delete',  'category' => 'Roles'],

            ['name' => 'country read'  ,  'category' => 'Countries'],
            ['name' => 'country create',  'category' => 'Countries'],
            ['name' => 'country edit'  ,  'category' => 'Countries'],
            ['name' => 'country delete',  'category' => 'Countries'],

            ['name' => 'city read'  ,  'category' => 'Cities'],
            ['name' => 'city create',  'category' => 'Cities'],
            ['name' => 'city edit'  ,  'category' => 'Cities'],
            ['name' => 'city delete',  'category' => 'Cities'],

            ['name' => 'nationality read'  ,  'category' => 'Nationalities'],
            ['name' => 'nationality create',  'category' => 'Nationalities'],
            ['name' => 'nationality edit'  ,  'category' => 'Nationalities'],
            ['name' => 'nationality delete',  'category' => 'Nationalities'],

            ['name' => 'memorization amount read'  ,  'category' => 'Memorization'],
            ['name' => 'memorization amount create',  'category' => 'Memorization'],
            ['name' => 'memorization amount edit'  ,  'category' => 'Memorization'],
            ['name' => 'memorization amount delete',  'category' => 'Memorization'],

            ['name' => 'memorization type read'  ,  'category' => 'Memorization'],
            ['name' => 'memorization type create',  'category' => 'Memorization'],
            ['name' => 'memorization type edit'  ,  'category' => 'Memorization'],
            ['name' => 'memorization type delete',  'category' => 'Memorization'],

            ['name' => 'level read'  ,  'category' => 'Levels'],
            ['name' => 'level create',  'category' => 'Levels'],
            ['name' => 'level edit'  ,  'category' => 'Levels'],
            ['name' => 'level delete',  'category' => 'Levels'],

            ['name' => 'level task read'  ,  'category' => 'Level Tasks'],
            ['name' => 'level task create',  'category' => 'Level Tasks'],
            ['name' => 'level task edit'  ,  'category' => 'Level Tasks'],
            ['name' => 'level task delete',  'category' => 'Level Tasks'],

            ['name' => 'track read'  ,  'category' => 'Tracks'],
            ['name' => 'track create',  'category' => 'Tracks'],
            ['name' => 'track edit'  ,  'category' => 'Tracks'],
            ['name' => 'track delete',  'category' => 'Tracks'],

            ['name' => 'digital badge read'  ,  'category' => 'Badges'],
            ['name' => 'digital badge create',  'category' => 'Badges'],
            ['name' => 'digital badge edit'  ,  'category' => 'Badges'],
            ['name' => 'digital badge delete',  'category' => 'Badges'],

            ['name' => 'teacher badge read'  ,  'category' => 'Badges'],
            ['name' => 'teacher badge create',  'category' => 'Badges'],
            ['name' => 'teacher badge edit'  ,  'category' => 'Badges'],
            ['name' => 'teacher badge delete',  'category' => 'Badges'],

            ['name' => 'student read'  ,  'category' => 'Students'],
            ['name' => 'student create',  'category' => 'Students'],
            ['name' => 'student edit'  ,  'category' => 'Students'],
            ['name' => 'student delete',  'category' => 'Students'],
            ['name' => 'student send notification',  'category' => 'Students'],

            ['name' => 'teacher read'  ,  'category' => 'Teachers'],
            ['name' => 'teacher create',  'category' => 'Teachers'],
            ['name' => 'teacher edit'  ,  'category' => 'Teachers'],
            ['name' => 'teacher delete',  'category' => 'Teachers'],
            ['name' => 'teacher send notification',  'category' => 'Teachers'],
            ['name' => 'add admin to teacher',  'category' => 'Teachers'],
            ['name' => 'add circle to teacher',  'category' => 'Teachers'],

            ['name' => 'circle type read'  ,  'category' => 'Circles'],
            ['name' => 'circle type create',  'category' => 'Circles'],
            ['name' => 'circle type edit'  ,  'category' => 'Circles'],
            ['name' => 'circle type delete',  'category' => 'Circles'],

            ['name' => 'circle read'  ,  'category' => 'Circles'],
            ['name' => 'circle create',  'category' => 'Circles'],
            ['name' => 'circle edit'  ,  'category' => 'Circles'],
            ['name' => 'circle delete',  'category' => 'Circles'],

            ['name' => 'quran read'  ,  'category' => 'Quran'],

            ['name' => 'database backup read',  'category' => 'Database Backup'],
            ['name' => 'database backup create',  'category' => 'Database Backup'],

            ['name' => 'join us read',  'category' => 'Join Us'],
            ['name' => 'join us edit',  'category' => 'Join Us'],

            ['name' => 'setting read',  'category' => 'Settings'],
            ['name' => 'setting edit',  'category' => 'Settings'],

        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']],[
                'name' => $permission['name'],
                'category' => $permission['category'],
            ]);
        }
    }
}
