<ol id="test-questions">
	@foreach($questions AS $question)
			
			@if($question->answered($currentUser->id) !== null && $question->answered($currentUser->id)->points >= 1) 
				<?php $listClass = 'answer-accepted'; ?>
			@else
				<?php $listClass = ''; ?>
			@endif
			
		<li class='{!!$listClass!!}'>
			<h4>{!! $question->question !!} [{!! $question->type->name !!}] [
				
				@if($question->answered($currentUser->id) !== null)
				
				<?php 
					$answer = $question->answered($currentUser->id)->answer;
					
					if($question->answered($currentUser->id)->points >= $question->weight){
						$color = 'green';
					}else{
						$color = 'red';
					}
					
					$message = '<p style="color:'.$color.';">*'.$question->answered($currentUser->id)->message.'</p>';
				?>
				
				<span style="color:{!!$color!!};">{!! $question->answered($currentUser->id)->points !!}</span>
				out of 
				
				@else
				
				<?php $answer = null; $message = null;?>
				
				@endif
				
				{!! $question->weight !!} points]</h4>	
				
				<span class="message">{!! $message !!}</span>
				
			@include('partials.tests.'.$question->type->code)
		</li>

	@endforeach
</ol>