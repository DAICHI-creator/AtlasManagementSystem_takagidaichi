<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Users\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'over_name' => '山田',
            'under_name' => '太郎',
            'over_name_kana' => 'ヤマダ',
            'under_name_kana' => 'タロウ',
            'mail_address' => 'yamada@example.com',
            'sex' => 1,
            'birth_day' => '2000-01-01',
            'role' => 1, // 国語教師
            'password' => Hash::make('password123')
        ]);

        User::create([
            'over_name' => '佐藤',
            'under_name' => '花子',
            'over_name_kana' => 'サトウ',
            'under_name_kana' => 'ハナコ',
            'mail_address' => 'satou@example.com',
            'sex' => 2,
            'birth_day' => '2003-03-15',
            'role' => 4, // 生徒
            'password' => Hash::make('password123')
        ]);
    }
}
