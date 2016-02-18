$(document).ready(function(){
	var click_counter=1;
	var pageToLoad = "<?php echo $data_path ?>?count=<?php echo $amens_per_page; ?>&page="+click_counter;
	var array_as_string = "";
	
	 $.getJSON(pageToLoad, function(result){

		 console.log("Total Amens:"+result.total );

			var array_as_string = "";

			$.each(result.data, function(i,data) {                    
			     var str = "_" + data.id;
			     array_as_string = array_as_string.concat(str);
			});

         $("#noteFeed").append("<span id=\'feed"+click_counter+"\'></span>")
         $('#feed'+click_counter).load('\/api\/v1\/amens\/array\/'+ array_as_string);

         $(".load_more").text('Load <?php echo $amens_per_page; ?> More');
         $("#loadinggif").attr('style','display:none;')

            if(click_counter >= result.total_pages)
    		{
				$(".load_more").attr("disabled",true).attr('style','display:none');
    		}
         
         });
	
    $("button").click(function(){
		
		click_counter++;
		
        $.getJSON("<?php echo $data_path ?>?count=<?php echo $amens_per_page; ?>&page="+click_counter, function(result){

        	$("#loadinggif").attr('style','display:inline;')
        	$(".load_more").text('Loading...');
			
        	$("#noteFeed").append("<hr id=\'firstInNewGroup"+click_counter+"\'");
			
        	var array_as_string = "";

			$.each(result.data, function(i,data) {                    
			     var str = "_" + data.id;
			     array_as_string = array_as_string.concat(str);
			});
			
         $("#noteFeed").append("<span id=\'feed"+click_counter+"\'></span>")
         $('#feed'+click_counter).load('\/api\/v1\/amens\/array\/'+ array_as_string);
            
            $("#loadinggif").attr('style','display:none;')
            $(".load_more").text('Load <?php echo $amens_per_page; ?> More');
            $(".load_more").attr("disabled",false);
       		
       		if(click_counter == result.last_page)
    		{
				$(".load_more").attr("disabled",true).text('the end');
    		}
    		
        });
    });
});