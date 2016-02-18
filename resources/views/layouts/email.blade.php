<!DOCTYPE html>
<html>

<body styles="max-width:600px; font-size:22px; font-family:Tahoma, Arial, sans-serif">

<nav>
	<center></center>
</nav>

<article>
	@yield('content')
</article>

<p>Sincerely,</p>

<p>Your friends at Bible exchange</p>

<footer>
<center><img src="{!!$message->embed('http://bible.exchange/images/be_logo_50.png')!!}"><a href="http://bible.exchange"><em>Bible exchange</em></a></center>
</footer>
</body>
</html>
