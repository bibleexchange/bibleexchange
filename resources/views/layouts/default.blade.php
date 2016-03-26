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
	<div id="security-token" style="display:none;">{!!csrf_token()!!}</div>
	<div id="root" ></div>
	
	<script src="/assets/js/app.min.js"></script>
</body>
</html>