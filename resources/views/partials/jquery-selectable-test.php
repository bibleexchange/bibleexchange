<!--deselectSelectable() is used to clear any  selected verses-->
			function deselectSelectable() {
				$(".ui-selected").removeClass("ui-selected"); 
				$( "#feedback" ).removeClass('slideInUp').addClass('slideOutDown');				
				}
			
			  $(function() {
			    $( "#bible" ).selectable({
					
			      stop: function() {
			        var result = $( "#select-result" ).empty();
			        $( ".ui-selected", this ).each(function() {

				      var index = $( ".ui-selected" ).attr('id');
				      var reference =  $( ".ui-selected" ).attr('title');
				      
			          result.append( index );

			          $('input[name="bible_verse_id"]').val(index);
			          $('input[id="reference"]').val(reference);
			          $( "#feedback" ).removeClass('off').removeClass('slideOutDown').addClass('slideInUp');

			          var jsonURL = '/api/v1/bible/' + index;
				
						  $.getJSON( jsonURL , function( data ) {

							var list = $( "#dynamic-verse-info-off" );
							  
							  var items = [];

							  $.each( data.data, function( key, val ) {
								 
							    items.push( "<li id='" + key + "'>" + val + "</li>" );
							  });
							 
							  $( "<ul/>", {
							    "class": "my-new-list",
							    html: items.join( "" )
							  }).appendTo( list );


								var linkReference = "<a href='"+data.data.link+"'>"+reference+"</a>";
								
								  $( "#select-reference" ).html(linkReference)
							  
							});

						delay:500	
			          
			        });
			        
			      }
			    });
			  });