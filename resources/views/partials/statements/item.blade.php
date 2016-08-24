<?php
  $statementModel = $statement;
  $statement = $statement->statementToJson();
  $stored = new Carbon\Carbon($statementModel->stored);
?>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-lg-12">
    <div class="statement-row clearfix">

      <span onclick="$('.state-{{ $statementModel->id }}').toggle();"><i class="icon icon-cog lightgrey pull-left"></i></span>

      <span class="pull-left statement-avatar">
          <img src="{{ $statementModel->avatar }}" alt='avatar' class="img-circle avatar" />
      </span> 
        
      {{ $statementModel->name }}

      <i>{{ $statementModel->displayVerb($lang) }}</i>
        
      <a href="{{ $statementModel->displayObjectId() }}">{{ $statementModel->displayObject($lang) }}</a>

      <small>| {{ $stored->diffForHumans() }} ({{ $stored->toDayDateTimeString() }})</small>

      <div class="full-statement state-{{ $statementModel->id }}" style="display:none;">
        <?php 
		$statement = \BibleExperience\Helpers\Helpers::replaceHtmlEntity( $statementModel->statement ); 		
		?>
        <pre>{{{ json_encode($statement,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}}</pre>
      </div>

    </div>
  </div>
</div>
