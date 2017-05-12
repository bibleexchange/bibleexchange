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
<link href="/styles.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans&subset=Latin">
</head>
<body>

{{phpinfo()}}
<div id="root"><div class="container"><header id="MainNavbar"><nav id="BrandNav"><a href="/"><span class="brandName">Bible exchange</span></a></nav></header><main><div id="dashboard"><form id="main-search"><input type="text" id="search-text" name="search" placeholder="search notes..."></form><div class="WidgetContainer"></div></div></main></div></div><script src="/app.js"></script>

</body></html>
