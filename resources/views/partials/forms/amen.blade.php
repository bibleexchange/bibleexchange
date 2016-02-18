@if ($currentUser)
    @if ($amenable->isAmenedBy($currentUser))
        {!! Form::open(['method' => 'DELETE', 'route' => ['amen_path'], 'class'=>'form-inline social-amen-form','style'=>'display:inline-block;']) !!}
            {!! Form::hidden('amenable_id', $amenable->id) !!}
            {!! Form::hidden('amenable_type',  get_class($amenable)) !!}
            <button class="social-amen remove-amen" type="submit">
            	Remove Amen
            	@if($amenable->amens->count() >= 1)
					({!! $amenable->amens->count() !!})
				@endif
            </button>
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => 'amens_path','class'=>'form-inline','style'=>'display:inline-block;']) !!}
            {!! Form::hidden('amenable_id', $amenable->id) !!}
            {!! Form::hidden('amenable_type', get_class($amenable)) !!}
            <button class="social-amen" style="background-color:transparent;" type="submit">
            	Amen
            	@if($amenable->amens->count() >= 1)
					({!! $amenable->amens->count() !!})
				@endif
            </button>
        {!! Form::close() !!}
    @endif
@endif