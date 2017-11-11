<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Role;
use App\Permission;

class RoleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
//        $this->assertTrue(true);
//        $admin = new Role();
//        $admin->name = 'admin';
//        $admin->display_name = 'User Administrator';
//        $admin->description = 'user allow to mange and edit other users';
//        $admin->save();
//
        $user = User::where('name','admin')->first();
//        $user->attachRole($admin);
//
//        $editUser = new Permission();
//        $editUser->name = 'edit-user';
//        $editUser->display_name = 'Edit Users';
//        $editUser->description = 'edit exising users';
//        $editUser->save();
//
//        $admin->attachPermission($editUser);

        $this->assertTrue($user->hasRole('admin'));
        $this->assertFalse($user->hasRole('user'));
        $this->assertTrue($user->can('edit-user'));
        $this->assertFalse($user->can('edit-other'));

    }
}
