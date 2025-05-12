<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Admin::firstOrCreate(['email' => 'admin@admin.com'],[
            'name' => 'admin',
            'phone' => '0123456789',
            'password' => bcrypt('123123123'),
        ]);

        $user->roles()->detach();
        $user->permissions()->detach();
        $role = Role::updateOrCreate(['name' => 'SuperAdmin'], [
            'name' => 'SuperAdmin',
        ]);
        $permissions = Permission::where('guard_name','admin_api')->pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
