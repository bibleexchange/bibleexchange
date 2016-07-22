<a class="navbar-brand" href="{{ URL::to('/') }}">
  <?php
    $site = \BibleExperience\Site::first();
    if( isset($site->name) ){
      $site = $site->name;
    }else{
      $site = 'Bible Experience';
    }
  ?>
  {{ isset($title) ? $title : $site }}
</a>