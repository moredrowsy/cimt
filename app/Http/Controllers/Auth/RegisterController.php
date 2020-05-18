<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Role;
use App\RoleAdmin;
use App\RoleCimt;
use App\RoleResProvider;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'address' => ['required', 'string', 'max:255'],
            'tel' => 'required|regex:/[0-9]{3}-[0-9]{3}-[0-9]{4}/',
        ], [
            'email.required' => 'The email is required.',
            'email.email' => 'The email needs to have a valid format.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        switch ($data['role']) {
            case 1:
                $user->admin()->save(
                    new RoleAdmin(['email' => $data['email']])
                );
                break;
            case 2:
                $user->cimt()->save(
                    new RoleCimt(['tel' => $data['tel']])
                );
                break;
            case 3:
                $user->res_provider()->save(
                    new RoleResProvider(['address' => $data['address']])
                );
                break;
            default:
        }

        return $user;
    }
}
