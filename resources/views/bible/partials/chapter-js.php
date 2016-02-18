$(document).ready(function(){
	
    var chapterId = <?php echo $chapter->id; ?>;
    
    loadHTML(chapterId);
    
});

function loadHTML(chapterId) {

    var path = "<?php echo $data_path ?>";
    var pageToLoad = path+chapterId;
    
    $.ajax({
	    url : pageToLoad,
	    type : 'GET',
	    data :  '',   
	    tryCount : 0,
	    retryLimit : 3,
	    success : function(data) {
	        
	     $( "#bibleWindow" ).html( data ); 
		
		 $("#nextChapter").click(function(e) {
		      e.preventDefault();
		      
		      loadHTML(nextChapterId(chapterId));
		      
		    });
		    
	    $("#nextChapterButton").click(function(e) {
	      	e.preventDefault();
	      	
	      	loadHTML(nextChapterId(chapterId));
		 
		 	$('html,body, #bible-text').animate({scrollTop: 0},'slow');
		      
		});
		    
		$('a.chapter-link').click(function(e) {
	    	e.preventDefault();
		  	var chapterId = $(e.target).attr('id');
		  	 loadHTML(chapterId);
		});
		
		$( "#bibleSearch" ).submit(function( event ) {
		  event.preventDefault();	
		  
		  var inputText = $('input#reference').val();
		  
		  searchBible(inputText);	  
		});
		
		$( "#bibleSearch" ).change(function( event ) {
		  event.preventDefault();	
		  var inputText = $('input#reference').val(); 
		}).change(); 
	      
	      loadHTML(nextChapterId(chapterId));
	      
	    });      
	        
	    },
	    error : function(xhr, textStatus, errorThrown ) {
	        if (textStatus == 'timeout') {
	            this.tryCount++;
	            if (this.tryCount <= this.retryLimit) {
	                //try again
	                $.ajax(this);
	                return;
	            }            
	            return;
	        }
	        if (xhr.status == 500) {
	            //handle error
	        } else {
	            //handle error
	        }
	    }
	});
	
}


function loadSearch(query, pageNumber) {
    
    var path = "/api/v1/bible/search/";
    var pageToLoad = path+query;
    
	$.get( pageToLoad, { page: pageNumber }, function( data ) {
	  $( "#bibleWindow #search-results" ).html( data ); 
	  
	  	$('#search-paginator a').click(function(e) {
	    	e.preventDefault();
		  	
		  	var pageNumber = $(e.target).text();
			
			loadSearch(query, pageNumber);
		
		});
	  
	  
	  	$('#bible-results a').click(function(e) {
	    	e.preventDefault();
		  	
		  	var chapterId = $(e.target).attr('id');
			
			loadHTML(chapterId);
		
		});
	  
	  });
	  
}

function nextChapterId(chapterId) {
    
	if(chapterId === 1189){
		var next = 1;
	}else{
		var next = chapterId+1; 
	}
	
	return next;
	
}

function previousChapterId(chapterId) {
    
	if(chapterId === 1){
		var previous = 1189;
	}else{
		var previous = chapterId-1; 
	}
	
	return previous;
	
}

function searchBible(input){
	
	var pageToLoad = '/api/v1/bible/search-reference/' + input;
	
	$.get( pageToLoad, function( data ) {
		
		if (data !== 'empty'){
			loadHTML(data);
		}else{
			
			loadSearch(input,1);
			
		}
		
	});
	
}