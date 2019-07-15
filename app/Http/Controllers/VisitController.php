<?php

    namespace App\Http\Controllers;

    use App\Location;
    use App\Profile;
    use App\Visit;
    use App\User;
    use Auth;
    use Carbon\Carbon;

    class VisitController extends Controller {

        protected $now;

        public function __construct() {
            $this->now =  $now = Carbon::now();
        }

        public function showViewedProfiles() {
            $profiles = Visit::where([
                'watcher' => Auth::id(),
                'deleted_by_watcher' => false
            ])->orderBy('date', 'desc')->get();

            foreach ($profiles as $profile) {
                $profile->user = Profile::find($profile->viewed);

                $visited = Carbon::parse($profile->date);
                $diff = $this->now->diffInMinutes($visited, true);
                $time = substr(explode(' ', $profile->date)[1], 0, 5);
                $profile->date = UsersController::getFineActivityView($diff, $visited, $time);

                $status = User::find($profile->viewed);
                $profile->user->status = $this->checkLastActivity($status);

                $profile->location = Location::find($profile->viewed);
            }

            return view('viewed-profiles', ['profiles' => $profiles]);
        }

        public function showUsersViewedMyProfile() {
            $profiles = Visit::where([
                'viewed' => Auth::id(),
                'deleted_by_viewed' => false
            ])->orderBy('date', 'desc')->get();

            foreach ($profiles as $profile) {
                $profile->user = Profile::find($profile->watcher);

                $visited = Carbon::parse($profile->date);
                $diff = $this->now->diffInMinutes($visited, true);
                $time = substr(explode(' ', $profile->date)[1], 0, 5);
                $profile->date = UsersController::getFineActivityView($diff, $visited, $time);

                $status = User::find($profile->viewed);
                $profile->user->status = $this->checkLastActivity($status);

                $profile->location = Location::find($profile->watcher);
            }

            return view('viewed-my-profile', ['profiles' => $profiles]);
        }

        protected function checkLastActivity(User $user) {
            if (!$user->isOnline()) {
                $last = Carbon::parse($user->last_activity);
                $diff = $this->now->diffInMinutes($last, true);
                $time = substr(explode(' ', $user->last_activity)[1], 0, 5);
                return 'last seen ' . UsersController::getFineActivityView($diff, $last, $time);
            }
            return 'online';
        }

        public function deleteViewedProfile($id) {
            $visit = Visit::where([
                'viewed' => $id,
                'watcher' => Auth::id()
            ])->first();

            $visit->update([
                'deleted_by_watcher' => true
            ]);

            return response()->json(['result' => true]);
        }

        public function deleteViewedMeProfile($id) {
//            $visit = Visit::where([
//                'viewed' => $id,
//                'watcher' => Auth::id()
//            ])->first();
//
//            if (!count($visit))
//                abort(419);
//
//            $visit->update([
//                'deleted_by_watcher' => true
//            ]);
//
//            return response()->json(['result' => true]);
        }
    }
