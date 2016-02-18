<a href="{!! route('profile_path', $user->username) !!}" class="avatar {!! $anchor_class or '' !!}"><img 
	class="media-object {!! $image_class or '' !!}" 
    src="{!! $user->present()->gravatar(isset($size) ? $size : 30) !!}" 
    width="{!! isset($size) ? $size : 30 !!}" 
    alt="{!! $user->username !!}"></a>