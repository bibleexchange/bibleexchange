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
<link href="/static/main.css" rel="stylesheet">
<link href="https://unpkg.com/tachyons@4.2.1/css/tachyons.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans&subset=Latin">

 <style type="text/css">body {
  margin: 0;
  padding: 0;
  font-family: sans-serif;
}

.answered-true {
  color:green;
}</style><style type="text/css">/* ==========================================================================
   COLOR
   ========================================================================== */
@-webkit-keyframes toggle {
  0% {
    stroke: gray;
    stroke-width: 35%; }
  40% {
    stroke: black;
    stroke-width: 20%; }
  100% {
    stroke: black;
    stroke-width: 5%; } }
@keyframes toggle {
  0% {
    stroke: gray;
    stroke-width: 35%; }
  40% {
    stroke: black;
    stroke-width: 20%; }
  100% {
    stroke: black;
    stroke-width: 5%; } }

#MainNavbar {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
      -ms-flex-pack: justify;
          justify-content: space-between;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  height: 50px;
  background-color: white;
  padding-left: 15px;
  padding-right: 15px;
  color: #777;
  margin: 0;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  z-index: 2500;
  position: relative;
  margin-bottom: 15px;
  overflow: hidden; }
  #MainNavbar li {
    display: inline;
    margin-left: 15px; }
  #MainNavbar #BrandNav {
    height: 100%; }
    #MainNavbar #BrandNav .BeLogo {
      height: 44px;
      display: inline-block;
      float: left;
      margin-top: 3px; }
    #MainNavbar #BrandNav a {
      display: inline-block;
      color: #777;
      height: 100%;
      text-decoration: none; }
      #MainNavbar #BrandNav a .brandName {
        display: none;
        font-size: 1.1rem;
        height: 100%;
        line-height: 50px;
        display: none;
        float: left;
        margin-left: 10px; }
      #MainNavbar #BrandNav a .beta {
        color: rgba(229, 92, 70, 0.45);
        display: none;
        border: none;
        line-height: 35px; }
  #MainNavbar #UserNav {
    margin: 0;
    padding: 0;
    height: 100%;
    white-space: nowrap;
    z-index: 1; }
    #MainNavbar #UserNav ul {
      margin: 0;
      padding: 0;
      height: 100%; }
      #MainNavbar #UserNav ul li {
        margin-left: 35px; }
    #MainNavbar #UserNav #open-close {
      border: none;
      height: 30px;
      width: 30px;
      margin: 0;
      padding: 0;
      margin-top: 10px;
      background: none; }
      #MainNavbar #UserNav #open-close .minimize {
        stroke: black;
        stroke-width: 5%;
        -webkit-animation-name: toggle;
                animation-name: toggle;
        -webkit-animation-duration: 1s;
                animation-duration: 1s; }
      #MainNavbar #UserNav #open-close .expand {
        stroke: black;
        stroke-width: 5%;
        -webkit-animation-name: toggle;
                animation-name: toggle;
        -webkit-animation-duration: 1s;
                animation-duration: 1s; }

@media screen and (min-width: 748px) {
  #MainNavbar #BrandNav a .brandName {
    display: inline-block; }
  #MainNavbar #BrandNav a .beta {
    display: inline-block; } }
</style><style type="text/css">/* ==========================================================================
   COLOR
   ========================================================================== */
/* Tooltip container */
.cross-reference {
  position: relative;
  display: inline-block;
  margin: 5px; }

/* Tooltip text */
.cross-reference .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  padding: 5px 0;
  border-radius: 6px;
  /* Position the tooltip text - see examples below! */
  position: absolute;
  z-index: 1; }

/* Show the tooltip text when you mouse over the tooltip container */
.cross-reference:hover .tooltiptext {
  visibility: visible; }
</style><style type="text/css">/* ==========================================================================
   COLOR
   ========================================================================== */
#bible-widget #bible-navigation {
  font-size: 1.2rem;
  border: 5px solid #317FB6;
  padding: 0; }
  #bible-widget #bible-navigation form {
    display: inline-block;
    margin: 0;
    padding: 0; }
    #bible-widget #bible-navigation form input {
      color: #E55C46;
      height: 50px;
      float: left;
      border: none;
      border-bottom: 2px #F9CA73 solid; }
    #bible-widget #bible-navigation form button {
      height: 50px;
      background: none;
      padding: 0;
      margin: 0;
      border: none;
      float: left; }
    #bible-widget #bible-navigation form #magnifying-glass {
      height: 50px;
      fill: #317FB6;
      width: 25px; }

#bible-widget .bible-verse {
  margin: 15px; }
</style><style type="text/css">/* ==========================================================================
   COLOR
   ========================================================================== */
.be-button, .be-button-red, .be-button-back, .be-button-simple, .be-button-simple-back {
  display: block;
  margin-top: 10px;
  padding: 5px;
  border: solid 5px #00C981;
  color: #00C981;
  font-weight: bold;
  background-image: url("http://localhost/assets/img/arrow.png");
  background-repeat: no-repeat;
  background-size: 30px 30px;
  background-position: right;
  text-align: center;
  text-decoration: none;
  background-color: white; }

.be-button-back, .be-button-simple-back {
  background-image: url("http://localhost/assets/img/arrow-left.png");
  background-position: left; }

.be-button:hover, .be-button-red:hover {
  background-color: #00C981;
  color: white;
  background-image: none; }

.be-button-red {
  color: #E55C46; }

.be-button-red:hover {
  background-color: #E55C46; }

.be-button-simple-back, .be-button-simple {
  border: none;
  height: 50px;
  width: 40px;
  float: left;
  margin: 0;
  padding: 0;
  background-color: none; }

.be-button-simple {
  float: right; }

.carousel {
  margin-left: auto; }
  .carousel ul {
    list-style: none; }
    .carousel ul .noBorder {
      background-image: none;
      margin-top: 100px; }
    .carousel ul li {
      float: left;
      margin: 15px;
      width: 230px;
      height: 300px;
      padding: 35px;
      border: none;
      background-image: url("http://localhost/assets/img/be_border.png");
      background-repeat: no-repeat;
      background-size: 230px 300px;
      overflow: hidden; }
      .carousel ul li p {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical; }
      .carousel ul li h2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical; }
      .carousel ul li #course, .carousel ul li #track {
        width: 80%; }

#home .row {
  clear: both;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto; }
</style><style type="text/css">#login-signup input {
  display: block;
  width: 100%;
  margin-bottom: 25px; }

@-webkit-keyframes spinner {
  to {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg); } }

@keyframes spinner {
  to {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg); } }

.spinner:before {
  content: '';
  box-sizing: border-box;
  position: absolute;
  width: 20px;
  height: 20px;
  margin-top: -10px;
  margin-left: -10px;
  border-radius: 50%;
  border: 2px solid #ccc;
  border-top-color: #333;
  -webkit-animation: spinner .6s linear infinite;
          animation: spinner .6s linear infinite; }

.ready-false .main {
  display: none; }

.ready-true .spinner {
  display: none; }
</style><style type="text/css">/* ==========================================================================
   COLOR
   ========================================================================== */
#my-notes.distraction-free-true {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 50px;
  left: 0;
  border: none;
  background-color: white; }

#my-notes .my-notes-false {
  display: none; }

#my-notes .my-notes-true li {
  display: block; }

#my-notes nav {
  background-color: #AAAAAA; }
  #my-notes nav li {
    display: inline;
    margin-bottom: 10px; }

#my-notes main input, #my-notes main textarea {
  width: 100%;
  margin-top: 25px; }

#my-notes main textarea {
  min-height: 600px;
  padding: 15px; }

#my-notes main label {
  margin-top: 10px;
  display: block;
  font-weight: bold; }

#my-notes main input#updated_at {
  font-style: italic;
  border: none;
  text-align: right;
  float: right;
  width: auto;
  display: inline-block;
  margin-top: 0; }

#my-notes main label.date {
  display: inline; }

#my-notes main div.line {
  width: 100%;
  min-width: 300px;
  margin-left: 0;
  margin-right: 0; }
</style><style type="text/css">/* ==========================================================================
   COLOR
   ========================================================================== */
#bible .row {
  max-width: 1000px;
  margin-left: auto;
  margin-right: auto;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
      -ms-flex-direction: row;
          flex-direction: row;
  -webkit-box-align: start;
      -ms-flex-align: start;
          align-items: flex-start; }
  #bible .row > div {
    margin: 15px;
    -webkit-box-flex: 1;
        -ms-flex: 1;
            flex: 1; }
</style><style type="text/css">#course .row {
  clear: both;
  maxWidth: 600px;
  marginLeft: auto;
  marginRight: auto; }
</style><style type="text/css">#note {
  background-color: white;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  margin: 15px;
  -webkit-box-flex: 1;
      -ms-flex: 1;
          flex: 1;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
      -ms-flex-flow: row wrap;
          flex-flow: row wrap;
  background-image: linear-gradient(180deg, white 3rem, #F0A4A4 calc(3rem), #F0A4A4 calc(3rem + 2px), transparent 1px), repeating-linear-gradient(0deg, transparent, transparent 1.5rem, #DDD 1px, #DDD calc(1.5rem + 1px));
  box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.25);
  padding: 0; }
  #note main {
    -webkit-box-flex: 3;
        -ms-flex: 3;
            flex: 3;
    margin: 0;
    padding: 15px;
    background: none;
    padding-top: 30px; }
    #note main h1, #note main div {
      display: block;
      float: none;
      clear: both; }
    #note main ul {
      list-style: none;
      margin: 0;
      padding: 0; }
      #note main ul li {
        margin: 0; }
  #note aside {
    -webkit-box-flex: 2;
        -ms-flex: 2;
            flex: 2;
    border-left: solid 1px gray;
    margin: 0;
    padding: 2%;
    background-color: white;
    overflow: hidden;
    word-wrap: break-word; }
  #note #note {
    background: none;
    box-shadow: none; }
    #note #note main {
      width: 100%;
      background: inherit; }
    #note #note aside {
      display: none;
      background: inherit; }

@media screen and (max-width: 650px) {
  #note {
    display: block;
    margin: 0; }
    #note main {
      display: block; }
    #note aside {
      display: block;
      border-top: solid 1px gray; } }
</style><style type="text/css">/* ==========================================================================
   COLOR
   ========================================================================== */
</style><style type="text/css">#dashboard {
  clear: both;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto; }
  #dashboard main {
    width: 75%;
    float: left; }
  #dashboard aside {
    width: 25%;
    float: left; }
</style>
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

<script src="/static/main.js"></script>

</body></html>
