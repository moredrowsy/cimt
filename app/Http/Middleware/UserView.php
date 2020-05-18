<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\ResIncRequest;

class UserView
{
    /**
     * Grabs user's view data and set $view to all views in controller
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            // user id
            View::share('user_id', $user->id);

            // user role
            if ($user->role_id == 1)
                View::share('view', [
                    'role' => User::find($user->id)->role->name,
                    'body' => User::find($user->id)->admin->email
                ]);
            else if ($user->role_id == 2)
                View::share('view', [
                    'role' => User::find($user->id)->role->name,
                    'body' => User::find($user->id)->cimt->tel
                ]);
            else if ($user->role_id == 3)
                View::share('view', [
                    'role' => User::find($user->id)->role->name,
                    'body' => User::find($user->id)->res_provider->address
                ]);

            // alert user resource/incident request counts
            $requesters = ResIncRequest::where('requester_id', $user->id)->where('status', 'Pending')->get();
            $requestees = ResIncRequest::where('requestee_id', $user->id)->where('status', 'Pending')->get();
            $requester_count = $requesters ? count($requesters) : 0;
            $requestee_count = $requestees ? count($requestees) : 0;
            View::share('requests', [
                'requesters' => $requester_count,
                'requestees' => $requestee_count
            ]);
        }
        return $next($request);
    }
}
