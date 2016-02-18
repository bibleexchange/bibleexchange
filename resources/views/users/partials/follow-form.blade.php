@if ($currentUser)
    @if ($user->isFollowedBy($currentUser))
        {!! Form::open(['method' => 'DELETE', 'route' => ['follow_path', $user->id]]) !!}
            {!! Form::hidden('userIdToUnfollow', $user->id) !!}
            <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> Unfollow <span class="hidden-xs">{!! $user->firstname !!}</span></button>
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => 'follows_path']) !!}
            {!! Form::hidden('userIdToFollow', $user->id) !!}
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> Follow <span class="hidden-xs">{!! $user->firstname !!}</span></button>
        {!! Form::close() !!}
    @endif
@endif