<?php

class Instagram
{
	
function __construct()
	{
		$this->feed = app_path().'/assets/docs/about-dbi/mjamesderocher.xml';
		//$this->feed = 'http://widget.stagram.com/rss/n/mjamesderocher';
	}

 function parse() {
    $rss = simplexml_load_file($this->feed,'SimpleXMLElement', LIBXML_NOCDATA);

    $photodisp = array();
	$i = 0;
	
    foreach ($rss->channel->item as $item) {
        $link = (string) $item->link;
        $title = (string) $item->title;
		$description = (string) $item->description;
				
		$imageUrl = (string) $item->image->url;
		$imageLink = (string) $item->image->link;
		$imageTitle = (string) $item->image->title;
		
		$this->posts[$i] = [
							'link'=>$link,
							'title'=>$title,
							'description'=>$description,
							'imageUrl'=>$imageUrl,
							'imageLink'=>$imageLink,
							'imageTitle'=>$imageTitle
							];
		$i++;
  }
 return $this->posts;
}
}
?>