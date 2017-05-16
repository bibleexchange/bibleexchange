<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8">
<title>{!! $pageTitle !!}</title>
<link rel="icon" type="image/png" href="favicon.ico" sizes="16x16">

@foreach($meta AS $m)

	@if(isset($m['name']))
		<meta name={!!  "\""  . $m['name'] .  "\"" !!} content={!!  "\""  . $m['content'] . "\"" !!}/>
	@else
		<meta property={!!  "\""  . $m['property'] .  "\"" !!} content={!! "\"" . $m['content'] . "\"" !!} />
	@endif
	
@endforeach

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

@keyframes pulse {
0%   { opacity: 1; }
100% { opacity: 0; }
}

h1.spcl {
	font-size: 4rem;
	text-align: center;
	color:gray;
}

.load {
  display: flex;
  position: relative;
  background: -webkit-linear-gradient(left, #28B6CD , #00C97B );
  height:100%;
}


  .load .ldr {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: space-around;
    align-items: center;
    margin: auto;
	width: 200px;
  }

    .load .ldr div{
    width: 100px;
    height: 100px;
  }

  .load .ldr-blk {
    animation: pulse 0.75s ease-in infinite alternate;
    background-color: #F6A45D;
  }

  .load .an_delay {
    animation-delay: 0.75s;
  }

</style>
<link href="/styles.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans&subset=Latin">
</head>
<body>

<div id="root">

<h1 class="spcl">Bible exchange is loading ...</h1>

<section class='load'>
      <div class='ldr'>
        <div class='ldr-blk'></div>
        <div class='ldr-blk an_delay'></div>
        <div class='ldr-blk an_delay'></div>
        <div class='ldr-blk'></div>
      </div>

</div>

<script src="/app.js"></script>

</body></html>
