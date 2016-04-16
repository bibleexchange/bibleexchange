<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="/assets/styles/all.css">
		<script src="/assets/tools/reloadr.js"></script>
		
		<script>
		// This code should go directly after your include line
		Reloadr.go({
				client: [
					'/assets/js/app.min.js',
					'/assets/styles/all.css'
				],
				server: [
					'*.php',
					'tests/*.php'
				],
				path: '/assets/tools/reloadr.php'
			});
		</script>

	</head>

<body>
	<div id="root" ></div>
	
	<script src="/assets/js/app.min.js"></script>
	
	<script>
	/*
	function mine(){
		var elements = document.getElementsByTagName('a');
		
		for (var i = 0, len = elements.length; i < len; i++) {
		  elements[i].addEventListener("click", function(e) {
			   e.preventDefault();
			   window.history.pushState(null, null, e.target.href);
		  });
		}
	}
	
	window.setTimeout(mine,500);
	*/
	</script>
	
</body>
</html>