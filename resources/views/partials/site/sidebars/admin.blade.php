@if( Auth::check() )

  <h4>Admin Options</h4>
  
  <ul class="nav nav-sidebar">
    <li class="@if ( isset($dash_nav) ) active @endif">
      <a href="{{ URL::to('/') }}"><span class="menu-icon"><i class="icon icon-dashboard"></i></span> Dashboard</a> 
    </li>
    <li class="@if ( isset($settings_nav) ) active @endif">
      <a href="{{ URL::to('/site#settings') }}"><span class="menu-icon"><i class="icon icon-cog"></i></span> Settings</a>
    </li>
    <li class="@if ( isset($lrs_nav) ) active @endif">
      <a href="{{ URL::to('/site#lrs') }}"><span class="menu-icon"><i class="icon icon-bar-chart"></i></span>  LRSs</a>
    </li>
    <li class="@if ( isset($users_nav) ) active @endif">
      <a href="{{ URL::to('/site#users') }}"><span class="menu-icon"><i class="icon icon-group"></i></span>  Users</a>
    </li>
    <!--
      <li class="@if ( isset($app_nav) ) active @endif">
        <a href="{{ URL::to('/site#apps') }}"><span class="menu-icon"><i class="icon icon-code"></i></span>  Apps</a>
      </li>
    -->
  </ul>
  
  @include('layouts.sidebars.sidebar_footer')

@endif