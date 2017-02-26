<?php
use stdclass;

$section_1 = new stdclass;
$section_1->title = "";
$s1_step1, $s1_step2, $s1_step3
$section_1->steps = [$s1_step1, $s1_step2, $s1_step3];

$section_2 = new stdclass;
$section_3 = new stdclass;

$romans  = new stdclass;
$romans->title = "Book of Romans";
$romans->name = "book-of-romans";
$romans->author = "Stephen Reynolds, Jr.";
$romans->description = "A thorough study of the Book of Romans.";
$romans->keywords = ["epistle","paul","exposition","romans","bible"];

$romans->sections = [$section_1, $section_2, $section_3];

 ?>



 "sections": [
 {
 "title":"Section 1",
 "steps": [
 	{"media":[{"id":"# Happy is the Man \n > Who&apos;s God is the Lord","type":"MARKDOWN"},{"id":"23494","type":"NOTE"},{"id":"romans 1:1","type":"BIBLE"}]},
 	{"media":[{"id":"1QGetvcJYaQ","type":"YOUTUBE"},{"id":"romans 5:1","type":"BIBLE"}]},
 	{"media":[{"id":"<h1>This is a test string</h1>","type":"STRING"},{"id":"romans 9:1","type":"BIBLE"}]}
 	]
 },
 {
 "title":"Section 2",
 "steps": [
 	{"media":[{"id":"What were you thinking?", "type":"STRING"},{"id":"<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/1QGetvcJYaQ?rel=0&amp;showinfo=0\" frameborder=\"0\" allowfullscreen></iframe>","type":"STRING"},{"id":"romans 2:2","type":"BIBLE"}]},
 	{"media":[{"id":"23494","type":"NOTE"},{"id":"romans 3","type":"BIBLE"}]},
 	{"media":[{"id":"23494","type":"NOTE"},{"id":{
 	"title": "Quiz on Genesis 6",
 	"instructions": "Answer each question carefully.",
 	"questions": [

 	{
 	"id":1,
 	"body":"Who Built the Ark?",
 	"type":"MULTIPLE_CHOICE",
 	"options": [
 		{"display":"Joseph", "value":0},
 		{"display":"Aaron", "value":0},
 		{"display":"Noah", "value":1},
 		{"display":"Paul", "value":0}
 		]
 	},

 	{
 	"id":2,
 	"body":"In the beginning God created the heaven and the earth.",
 	"type":"FILL_IN_THE_BLANK",
 	"options": ["beginning","created","heaven"]
 	}

 	]
 },"type":"QUIZ"}]}
 ]}

 ]
 }
