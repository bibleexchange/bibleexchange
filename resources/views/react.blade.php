<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Bible exchange | Your Place for Bible Sharing and Discovery</title>
  <link rel="icon" type="image/png" href="favicon.ico" sizes="16x16">
  <meta name="application-name" content="Bible exchange"/>
  <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/styles.css" rel="stylesheet">
<!-- <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans&amp;subset=latin"> -->
</head>
<body>

<div id="root"></div>
<script src="/app.js"></script>
<script>
setTimeout(function() {
    //service worker
    var newScript = document.createElement('script');
    newScript.type = 'text/javascript';
    newScript.src = '/service-worker.js';

    var headID = document.getElementsByTagName("head")[0];
    headID.appendChild(newScript);
  });
</script>
</body>
</html>
