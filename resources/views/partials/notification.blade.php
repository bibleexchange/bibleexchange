<li class="notification-{!!$notification->is_read!!}">	{{-- $notification->subject --}} {!! $notification->body !!}
	
	<a href="{!! url($notification->getObject()->url()) !!}">{!! $notification->getObject()->hint() !!}</a>
</li>