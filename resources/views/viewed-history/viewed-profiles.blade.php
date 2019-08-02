@extends ('layouts.app')

@section('content')

    <wsconnecting-component></wsconnecting-component> {{-- connecting to ratchet websocket server --}}

    <div class="container" id="main_container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">My viewed profiles</div>
                    <div class="row card-body">
                        @if (count($profiles))
                            @foreach($profiles as $profile)
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="list_users">
                                        <a href="{{ route('show.certain.user', $profile->user->login) }}">
                                            <div class="list_users_avatar_div">
                                                    <img src="{{ URL::asset($profile->user->avatar) }}"
                                                         alt="{{ $profile->user->login }}'s avatar" class="list_users_avatar"
                                                         title="{{ $profile->user->login }}">
                                            </div>
                                            <div class="list_users_info">

                                                {{ $profile->user->name }} {{ $profile->user->surname }}

                                                @if($profile->location->allow)
                                                    from {{ $profile->location->country }}, {{ $profile->location->city }}
                                                @endif

                                                <div class="list_users_activity">

                                                @if ($profile->user->status === 'online')
                                                    <span style="color: #1e7e34">{{ $profile->user->status }}</span>
                                                @else
                                                    <span>{{ $profile->user->status }}</span>
                                                @endif
                                                </div>
                                                Visited by you: {{ $profile->visited }}

                                                <form action="{{ route('delete.viewed.profile', $profile->user->user_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit">delete from history</button>
                                                </form>

                                                <p></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>You haven't viewed any profiles yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection