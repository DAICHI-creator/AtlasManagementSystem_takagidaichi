<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'over_name' => '山田',
                'under_name' => '太郎',
                'over_name_kana' => 'ヤマダ',
                'under_name_kana' => 'タロウ',
                'mail_address' => 'taro@example.com',
                'sex' => 1,
                'birth_day' => '1990-01-01',
                'role' => 1,
                'password' => Hash::make('test1234'),
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'over_name' => '佐藤',
                'under_name' => '花子',
                'over_name_kana' => 'サトウ',
                'under_name_kana' => 'ハナコ',
                'mail_address' => 'hanako@example.com',
                'sex' => 2,
                'birth_day' => '1992-05-15',
                'role' => 4,
                'password' => Hash::make('test1234'),
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);


    }
}
