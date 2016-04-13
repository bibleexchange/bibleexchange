<?php echo'<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">
  <channel>
    <atom:link href="{{$feed->url}}" rel="self" type="application/rss+xml"/>
    <title>{{$feed->title}}</title>
    <link>{{$feed->channel_url}}</link>
    <pubDate>{{$feed->created_date}}</pubDate>
    <lastBuildDate>{!!$feed->updated_date!!}</lastBuildDate>
    <ttl>{{$feed->items_count}}</ttl>
    <language>en</language>
    <copyright>{{$feed->rights}}</copyright>
    <webMaster>be@deliverance.me (Bible exchange Feeds)</webMaster>
    <description>{{$feed->description}}</description>
    <itunes:subtitle>Bible exchange is your companion in Bible discovery.</itunes:subtitle>
    <itunes:owner>
      <itunes:name>Bible exchange</itunes:name>
      <itunes:email>be@deliverance.me</itunes:email>
    </itunes:owner>
    <itunes:author>Bible exchange</itunes:author>
    <itunes:explicit>no</itunes:explicit>
    <itunes:image href="{{$feed->image->src}}"/>
    
    <itunes:category text="Religion &amp; Spirituality">
		<itunes:category text="Christianity" />
	</itunes:category>
    
    <image>
      <url>{{$feed->image->src}}</url>
      <title>{{$feed->title}}</title>
      <link>{{$feed->channel_url}}</link>
    </image>
    
    @foreach($entries AS $entry)
    
    <item>
      <guid>{{$entry->guid}}</guid>
      <title>{{$entry->title}}</title>
      <pubDate>{{$entry->updatedLast}}</pubDate>
      <link>{{$entry->link}}</link>
    
      <itunes:duration>{{$entry->recording_duration}}</itunes:duration>

      <itunes:author>{{$entry->author}}</itunes:author>
      <itunes:explicit>no</itunes:explicit>
      <itunes:summary>{{$entry->summary}}</itunes:summary>
      <itunes:subtitle>{{$entry->subtitle}}</itunes:subtitle>
      <description>{{$entry->summary}}</description>
      
      <enclosure 
      	type="{{$entry->recording_type}}" 
      	url="{{$entry->recording_download_url }}" 
      	length="{{$entry->recording_length}} "
      	/>

      <itunes:image href="{{$entry->image}}"/>
    </item>
    
    @endforeach
    
  </channel>
</rss>