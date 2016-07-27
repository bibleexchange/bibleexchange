<tr>
  <td>
    <a href="{{ URL::to('/lrs/'.$lrs->id) }}">{{ $lrs->title }}</a>
  </td>
  <td>
    {{ $lrs->description }}
  </td>
  <td>
    {{ count($lrs->members )}}
  </td>
  <td>
    {{ $lrs->created_at }}
  </td>

  <td>
    @if ( \BibleExperience\Helpers\Lrs::lrsEdit($lrs) )
      <a href="{{ URL::to('/lrs/'.$lrs->id.'/edit') }}" class="btn btn-xs btn-success btn-space" title="{{ Lang::get('site.edit') }}"><i class="icon-pencil"></i></a>
    @endif
	 
  </td>
  <td>
    @if ( \BibleExperience\Helpers\Lrs::lrsEdit($lrs) )
      @include('partials.lrs.forms.delete')
    @endif
  </td>
</tr>