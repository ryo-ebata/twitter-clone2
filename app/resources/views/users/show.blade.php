@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <div class="card shadow-sm">
                <div class="d-inline-flex">
                    <div class="p-3 d-flex flex-column">
                        <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="100" height="100">
                        <div class="mt-3 d-flex flex-column">
                            <h4 class="font-weight-bold">{{ $user->name }}</h4>
                            <span class="text-secondary">{{ $user->screen_name }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="p-3 d-flex flex-column justify-content-between">
                            <div class="d-flex">
                                <div>
                                    @if ($user->id === Auth::user()->id)
                                        <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn btn-primary">{{ __('Edit Profile') }}</a>
                                    @else
                                        @if ($is_following)
                                            <form action="{{ route('unfollow', ['user' => $user->id]) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" class="btn btn-danger">{{ __('Unfollow') }}</button>
                                            </form>
                                        @else
                                            <form action="{{ route('follow', ['user' => $user->id]) }}" method="POST">
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn btn-primary">{{ __('Follow') }}</button>
                                            </form>
                                        @endif

                                        @if ($is_followed)
                                            <span class="mt-2 px-1 bg-secondary text-light">{{ __('Follwed by') }}</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">{{ __('Tweet') }}</p>
                                <span>{{ $tweet_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">{{ __('Follow') }}</p>
                                <span>{{ $follow_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">{{ __('Follower') }}</p>
                                <span>{{ $follower_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($timelines))
            @foreach ($timelines as $timeline)
                <div class="col-md-8 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                            <div class="ml-2 d-flex flex-column flex-grow-1">
                                <p class="mb-0">{{ $timeline->user->name }}</p>
                                <a href="{{ url('users/' .$timeline->user->id) }}">{{ $timeline->user->screen_name }}</a>
                            </div>
                            <div>
                                <p>{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $timeline->text }}
                        </div>
                        <div class="card-footer py-1 d-flex justify-content-end bg-white">
                            @if ($timeline->user->id === Auth::user()->id)
                                <div class="dropdown mr-3 d-flex align-items-center">
                                    <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-fw"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <form method="POST" action="{{ url('tweets/' .$timeline->id) }}" class="mb-0">
                                            @csrf
                                            @method('DELETE')

                                            <a href="{{ url('tweets/' .$timeline->id .'/edit') }}" class="dropdown-item">{{ __('Edit') }}</a>
                                            <button type="submit" class="dropdown-item del-btn">{{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                </div>
                            @endif


                            <div class="mr-3 d-flex align-items-center">
                                <a href="{{ url('tweets/' .$timeline->id) }}"><i class="far fa-comment fa-fw"></i></a>
                                <p class="mb-0 text-secondary">{{ count($timeline->comments) }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                @if (!in_array(Auth::user()->id, array_column($timeline->favorites->toArray(), 'user_id'), TRUE))
                                    <form method="POST" action="{{ url('favorites/') }}" class="mb-0">
                                        @csrf

                                        <input type="hidden" name="tweet_id" value="{{ $timeline->id }}">
                                        <button type="submit" class="p-0 border-0 Likes m-3"><span class="Likes-Icon"></span></button>
                                    </form>
                                @else
                                    <form method="POST"action="{{ url('favorites/' .array_column($timeline->favorites->toArray(), 'id', 'user_id')[Auth::user()->id]) }}" class="mb-0">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn p-0 border-0 text-danger m-1"><i class="fas fa-heart fa-fw"></i></button>
                                    </form>
                                @endif
                                <p class="mb-0 text-secondary">{{ count($timeline->favorites) }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="my-4 d-flex justify-content-center">
        {{ $timelines->links() }}
    </div>
</div>
@include('layouts.tweet', ['user' => auth()->user()])
@endsection