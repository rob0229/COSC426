	/*-----Generate Popular Trip---------*/
		$(window).load(function(){
		
		 var _self = this;
			
		$(".poptriprow").on("click", function(){
		
				console.log($(this).attr("id"));		
				//Generate User popular trip when botton is clicked
				var tripInfo = [$("#stdate").val(), $("#endate").val(), $("#citydest").val(), $(this).attr("value")];			
				var arr = ($(this).attr("id"));
				var itemstring = arr.split("");
				var items = new Array();
				
				for (var i=0; i<arr.length; i++)
				{
					items.push(itemstring[i]);
				}
				
				console.log($(this).attr("value"));	
				var tripInfo = []

			/*	$.post("processors/itineraryGenerator.php", {
					
					
					
					
					tripInfo: tripInfo,
					items: JSON.stringify(items)
				}, function(e){
					console.log("Result is " + e + ", ");
					var array = JSON.parse(e);
					
					if(array[0] == -1){
						console.log(array[1]);
						$("#messageContainer").fadeIn();
						$("#messageContainer #message").html(array[1] + "<span>Click anywhere to make this message disappear</span>");
					} else {

						window.location = "itinerary.php?tripID="+ array;
					}
				});	
				*/

		});
		});
		
		
