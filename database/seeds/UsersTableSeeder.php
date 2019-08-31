<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [[
            'id'             => 1,
            'name'           => 'Nimit',
            'email'          => 'nimitrathod1997@gmail.com',
            'password'       => '$2b$10$1ZCTbKlu4WJzqKCZ5usvQekcJr5xxcEmdl8BXArX5o0SC.QQ5N6VC',
            'remember_token' => null,
            'created_at'     => '2019-06-19 19:13:32',
            'updated_at'     => '2019-06-19 19:13:32',
        ]];

        User::insert($users);

        User::findOrFail(1)->roles()->sync(1);
    }
}
