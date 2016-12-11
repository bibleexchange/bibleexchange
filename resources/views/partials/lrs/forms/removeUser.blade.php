{{ Form::model($lrs, array('route' => array('lrs.remove', $lrs->id), 
      'method' => 'PUT')) }}
  {{ form::hidden('user', $user['id']) }}
  <button type="submit" class="btn btn-default btn-xs">{{ Lang::get('site.remove') }}</button>
{{ Form::close() }}