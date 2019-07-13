<?php

    namespace App\Http\Controllers;
    
    use App\Interest;
    use App\Profile;
    use App\User;
    use App\Location;
    use Carbon\Carbon;

    class UsersController extends Controller {
    
        public function show() {
        
            $users = User::select()->get();
        
            foreach ($users as $user) {
                if (!$user->isOnline()) {
                    $now = Carbon::now();
                    $last = Carbon::parse($user->last_activity);
                    $diff = $now->diffInMinutes($last, true);
                    $time = substr(explode(' ', $user->last_activity)[1], 0, 5);
                    $user->last_activity = $this->getFineActivityView($diff, $last, $time);
                }
                $data[] = $user;
            }
            return view('users', ['users' => $users]);
        }
        
        public function showUser($login) {
            $user = User::where('login', $login)->first();
        
            if (!$user)
                return abort(404);
            
            if ($login === auth()->user()->login)
                return redirect('profile');
        
            $profile = Profile::find($user->id);
            $location = Location::find($user->id);
            $interests = Interest::where('user_id', $user->id)->get();
        
            $profile['login'] = $user->login;
            $profile['country'] = $location->country;
            $profile['allow'] = $location->allow;
            $profile['city'] = $location->city;
            $profile['interests'] = $interests;
            $profile['last_activity'] = $this->checkLastActivity($user);
        
            return view('user', ['profile' => $profile]);
        }
        
        protected function checkLastActivity(User $user) {
            if (!$user->isOnline()) {
                $now = Carbon::now();
                $last = Carbon::parse($user->last_activity);
                $diff = $now->diffInMinutes($last, true);
                $time = substr(explode(' ', $user->last_activity)[1], 0, 5);
                return 'last seen ' . $this->getFineActivityView($diff, $last, $time);
            }
            return 'online';
        }
    
        public function getFineActivityView($diff, $last, $time) {
        
            switch ($diff) {
                case $diff === 1:
                    return 'a few seconds ago';
                case $diff === 2:
                    return 'one minute ago';
                case $diff < 6:
                    return 'a few minutes ago';
                case $diff > 6 && $diff < 60:
                    return $diff . ' minutes ago';
                case $diff > 60 && $diff < 120:
                    return 'one hour ago';
                case $diff > 120 && $diff < 1440:
                    return (int)($diff / 60) . ' hours ago';
            }
            return $last->toFormattedDateString() . ' at ' . $time;
        }
    }