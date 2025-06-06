<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use DB;

use App\Models\Users\Subjects;
use App\Models\Users\User;
use App\Http\Requests\RegisterUserRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'over_name' => ['required', 'string', 'max:10'],
            'under_name' => ['required', 'string', 'max:10'],
            'over_name_kana' => ['required', 'string', 'regex:/^[ァ-ヶー]+$/u', 'max:30'],
            'under_name_kana' => ['required', 'string', 'regex:/^[ァ-ヶー]+$/u', 'max:30'],
            'mail_address' => ['required', 'string', 'email', 'max:100', 'unique:users,mail_address'],
            'sex' => ['required', 'in:1,2,3'],
            'old_year' => ['required', 'integer', 'between:2000,' . now()->year],
            'old_month' => ['required', 'integer', 'between:1,12'],
            'old_day' => ['required', 'integer', 'between:1,31'],
            'role' => ['required', 'in:1,2,3,4'],
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
        ], [
            'over_name.required'       => '姓は必須項目です。',
            'under_name.required'      => '名は必須項目です。',
            'over_name_kana.required'  => '姓（カナ）は必須項目です。',
            'over_name_kana.regex'     => '姓（カナ）はカタカナで入力してください。',
            'under_name_kana.required' => '名（カナ）は必須項目です。',
            'under_name_kana.regex'    => '名（カナ）はカタカナで入力してください。',
            'mail_address.required'    => 'メールアドレスは必須項目です。',
            'mail_address.email'       => '正しいメールアドレス形式で入力してください。',
            'mail_address.unique'      => 'このメールアドレスは既に登録されています。',
            'sex.required'             => '性別を選択してください。',
            'sex.in'                   => '選択した性別が正しくありません。',
            'old_year.required'        => '生年月日（年）を選択してください。',
            'old_month.required'       => '生年月日（月）を選択してください。',
            'old_day.required'         => '生年月日（日）を選択してください。',
            'role.required'            => '役職を選択してください。',
            'password.required'        => 'パスワードは必須項目です。',
            'password.min'             => 'パスワードは8文字以上で入力してください。',
            'password.max'             => 'パスワードは30文字以下で入力してください。',
            'password.confirmed'       => 'パスワードと確認用パスワードが一致しません。',
        ]);

        DB::beginTransaction();
        try{
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;

            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);
            if($request->role == 4){
                $user = User::findOrFail($user_get->id);
                $user->subjects()->attach($subjects);
            }
            DB::commit();
            return view('auth.login.login');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
