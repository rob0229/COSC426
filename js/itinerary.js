function itinerary(){
	var variables = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	var temp = variables[0].split('=');
	var tripID = temp[1];

	this.loadPage = function(){
			var _self = this;
			_self.navigation();	
			_self.dayChange();
			$(".timeline").first().css("display", "inline");
			var date = $(".timeline").first().data("day");
			_self.initialize(date);
	}


	//////////////////////////////////////////////////////////////////////////////////////////////
	//All controls for Google Maps    															//
	//Reference:                                                         						//
	//https://developers.google.com/maps/documentation/javascript/directions#DirectionsRequests //
	//////////////////////////////////////////////////////////////////////////////////////////////
 	this.initialize = function(date){
 		var directionsDisplay;
		var directionsService = new google.maps.DirectionsService();
		var map;
		directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers:true});
		//directionsDisplay.suppressMarkers = true;
		///////////////////////////////////////////////////////////////////////////////
		//TODO:
		//This should be thier customizable starting position
		var home; //Henson Science Hall
		////////////////////////////////////////////////////////////////////////////////
		
		var latlong=[];
		var mappoints =[];
		var pointNames = [];
		// var variables = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		// var temp = variables[0].split('=');
		// var tripID = temp[1];
		console.log(tripID);

		//Display the route on the map
		$.post("processors/getMapWayPoints.php",{
			tripID: tripID,
			date: date
		}, function(e){
			console.log("Return is " + e);
			latlong = JSON.parse(e);
			home = new google.maps.LatLng(latlong[1], latlong[2]);
			var mapOptions = {
				    zoom: 11,
				    center: home,
    				    mapTypeControlOptions: {
    				    style: google.maps.MapTypeControlStyle.DEFAULT,
      				    mapTypeIds: [
      				    google.maps.MapTypeId.ROADMAP,
       				    google.maps.MapTypeId.TERRAIN
     					 ]
   				    },
    				   zoomControl: true,
   				   zoomControlOptions: {
     			           style: google.maps.ZoomControlStyle.SMALL
  				  }
				};
				
				map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
				
				directionsDisplay.setMap(map);
				
				
				
				// function enableScrollingWithMouseWheel() {
  		// 		map.setOptions({ scrollwheel: true });
				// }
				
				var marker = new google.maps.Marker({
						map: map,
						draggable: false,
						position: home,
						visible: true
					});
				
				//iterate through each locations lat/long and add it to the mappoints array for the route plotting
				for(var i = 0; i < latlong.length; i+=3){
				
					//capture name, lat, and long from each index
					var name = latlong[i];
					var lat = latlong[i+1];
					var lng = latlong[i+2];
					
					//create google lat/long point object
					var pt = new google.maps.LatLng(lat, lng);
					
					//add location to mappoints array and names to pointNames array
					mappoints.push({location:pt, stopover:true}) ;
					pointNames.push(name);
					
					
					//create map marker, give coordinates and set visible
					var marker = new google.maps.Marker({
						map: map,
						draggable: false,
						position: pt,
						visible: true
					});
					
					//create infowindow to contain location name for marker
					var infowindow = new google.maps.InfoWindow({
    					content: "holding.."
  					});
  					
  					//function to bind current infowindow to current marker
  					bindInfoW(marker, name, infowindow);

  					function bindInfoW(marker, name, infowindow)
					{
     					google.maps.event.addListener(marker, 'click', function() {
     						
            				infowindow.setContent("<p style=\"color:black;\">"+name+"</p>");
           				infowindow.open(map, marker);
     					   });
					}
				}
				
				
				//for (var z=0; z < mappoints.length; z++)
				//{
					var request = {
     					origin:home,
      					destination:home,
      					waypoints: mappoints,
      					optimizeWaypoints: false,
      					travelMode: google.maps.TravelMode.DRIVING
					};
					
 			       		directionsService.route(request, function(response, status) {
    				
    						if (status == google.maps.DirectionsStatus.OK) {
    							directionsDisplay.setDirections(response);
   						 }
 					 });
 					
 					
 				//}
					
		  	});
	}
	
	
	this.navigation = function(){
		var _self = this;		
		$("#timeBtn").on('click', function(){
			$("#map-canvas.big").slideUp();
			$(".timeline").slideDown();
		});
		
		$("#mapBtn").on('click', function(){
			$("#map-canvas.big").slideDown();
			$(".timeline").slideUp();
		});

		$(".editItinerary:not(.save)").live('click', function(){
			//console.log($(this).parent().parent().data("day"));
		


			// $(".timeline").each(function(){
			// 	var _self = this;
			//  	var time = $(this).children(".time").text();
			// 	var timeDate = $(this).data("day");
			// 	console.log(timeDate);
			// 	var date = timeDate.split("/");
			// 	console.log(date[0] + ", "+date[1]);





			 // 	console.log(time);
			 // 	time = time.split(":");
				// if(time[1].substr(time[1].length-2) == "pm"){
				// 	time[0] = parseInt(time[0]) + 12;
				// 	if(time[0] == 24){
				// 		time[0] = 12;
				// 	}
				// } else {
				// 	time[0] = parseInt(time[0]);
				// }
				// time[1] = parseInt(time[1]);
				// //console.log("<input type=\"datetime-local\" value=\""+"2015"+"-"+date[0]+"-"+date[1]+"T"+time[0] +":0"+ time[1] +"\">");
				// if(time[0] < 10){
				// 	//$(this).children(".time").html("<input type='date' value='0"+ time[0] +":0"+ time[1] +"' >");
				// 	$(this).children(".time").html("<input type=\"datetime-local\" value=\""+"2015"+"-"+date[0]+"-"+date[1]+"T0"+time[0] +":0"+ time[1] +"\">");
				// } else {
				// 	$(this).children(".time").html("<input type=\"datetime-local\"  value=\""+"2015"+"-"+date[0]+"-"+date[1]+"T"+time[0] +":0"+ time[1] +"\">");
				// 	//$(this).children(".time").html("<input type='date' value='"+ time[0] +":0"+ time[1] +"' >");
				// }
		//	});










			 $(".point").each(function(){
					var timeDate = $(this).parent().parent().data("day");
					console.log(timeDate);
					var date = timeDate.split("/");
					console.log(date[0] + ", "+date[1]);
				var time = $(this).children(".time").text();
				console.log(time);
				time = time.split(":");


				if(time[1].substr(time[1].length-2) == "pm"){
					time[0] = parseInt(time[0]) + 12;
					if(time[0] == 24){
						time[0] = 12;
					}
				} else {
					time[0] = parseInt(time[0]);
				}
				time[1] = parseInt(time[1]);
				//console.log("<input type=\"datetime-local\" value=\""+"2015"+"-"+date[0]+"-"+date[1]+"T"+time[0] +":0"+ time[1] +"\">");
				if(time[0] < 10){
					//$(this).children(".time").html("<input type='date' value='0"+ time[0] +":0"+ time[1] +"' >");
					$(this).children(".time").html("<input type=\"datetime-local\" value=\""+"2015"+"-"+date[0]+"-"+date[1]+"T0"+time[0] +":0"+ time[1] +"\">");
				} else {
					$(this).children(".time").html("<input type=\"datetime-local\"  value=\""+"2015"+"-"+date[0]+"-"+date[1]+"T"+time[0] +":0"+ time[1] +"\">");
					//$(this).children(".time").html("<input type='date' value='"+ time[0] +":0"+ time[1] +"' >");
				}
			});
		$(this).text("Save");
		$(this).addClass("save");
		});
	
		$(".editItinerary.save").live('click', function(){
			var time = [];
			var locID = [];
			//var tripId = [];
			$("input").each(function(index){
				time.push($(this).val());
				
			});
			$(".loc").each(function(index){
				locID.push($(this).data("loc"));
				console.log($(this).data("loc"));
			});
			$(".point").each(function(index){
				console.log(time[index]);
				var sepDateTime = time[index].split("T");
				var timeSplit = sepDateTime[1].split(":");
				var t = sepDateTime[1].replace(":","");
				console.log(" " + timeSplit[0]);
			
				var period = "am";
				if(parseInt(timeSplit[0]) >= 13){
					period = "pm";
					timeSplit[0] = parseInt(timeSplit[0]) - 12;
				} else if(timeSplit[0] == 12){
					period = "pm"
				}
				$(this).children(".time").html("<div class='time'>"+ timeSplit[0] +":"+ timeSplit[1] + period +"</div>");


				console.log(" tripID: "+tripID+" locID: "+locID[index]+" date: "+sepDateTime[0]+" time: "+t);



				$.post("processors/updateItinerary.php",{
					tripID: tripID,
					locID: locID[index],
					date: sepDateTime[0],
					time: t
				},function(e){
					window.location = "itinerary.php?tripID="+ tripID ;
					//console.log(e);
				});

			});
			console.log(time);

			console.log("Location: "+ locID[0]+ " time: " + time[0]);
			$(this).text("Edit");
			$(this).removeClass("save");
		});

		$("#emailItineraryBtn").on("click", function(){
			console.log("Email Itinerary Btn Clicked");
			jQuery("#loading").fadeIn();
			
			$.post("processors/emailItinerary.php", {
				tripID: tripID
			 }, function(e){
			// 	//var res = JSON.parse(e);
			// 	//console.log(res);
			$("#loading").fadeOut();
			alert("Email Sent");
		});

		});
	}


    
    this.dayChange = function(){
    	var _self = this;
		$(".dropdown.day").on('click', function(){
			
			var date = $(this).data("day");
			var elem = $('.timeline[data-day="'+ date +'"]');
			$(".timeline").css("display", "none");
			elem.css("display", "block");
			console.log("Date: "+ date);
			//console.log(elem.html());
			_self.initialize(date);
		});
	}
//Set map
		// var directionsDisplay;
		// var directionsService = new google.maps.DirectionsService();
		// var map;
		// directionsDisplay = new google.maps.DirectionsRenderer();
		// ///////////////////////////////////////////////////////////////////////////////
		// //TODO:
		// //This should be thier customizable starting position
		// var home = new google.maps.LatLng( 38.345279, -75.605676); //Henson Science Hall
		// ////////////////////////////////////////////////////////////////////////////////
		
		// var latlong=[];
		// var mappoints =[];
		// var pointNames = [];
		// var variables = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		// var temp = variables[0].split('=');
		// var tripID = temp[1];
		// console.log("Trip Id is " + tripID);
		// console.log("Date is: " + date);
		// //Display the route on the map
		// $.post("processors/getMapWayPoints.php",{
		// 	tripID: tripID,
		// 	date: date
		// }, function(e){
		// 	console.log("Return is " + e);
		// 	latlong = JSON.parse(e);

		// 		//iterate through each locations lat/long and add it to the mappoints array for the route plotting
		// 		for(var i = 0; i < latlong.length; i+=3){
		// 			var name = latlong[i];
		// 			var lat = latlong[i+1];
		// 			var lng = latlong[i+2];
		// 			//create google lat/long point object
		// 			var pt = new google.maps.LatLng(lat, lng);
		// 			//add the location to the array for the route
		// 			mappoints.push({location:pt, stopover:true}) ;
		// 			pointNames.push(name);
		// 		}
								  
		// 		var mapOptions = {
		// 		    zoom:11,
		// 		    center: home
		// 		}
		// 		map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		// 		directionsDisplay.setMap(map);
		// 		var request = {
		// 		    origin:home,
		// 		    destination:home,
		// 		   	waypoints: mappoints,
		// 		    //optimizeWaypoints: true,
		// 		    travelMode: google.maps.TravelMode.DRIVING
		// 		};
		// 		directionsService.route(request, function(result, status) {
		// 		    if (status == google.maps.DirectionsStatus.OK) {
		// 		      directionsDisplay.setDirections(result);
		// 		    }
		// 		});
		//   	});


	this.loadPage();
	
}

//start of createMarker function
					
			//end of createMarker function
			

function getMarkerImage(iconStr) {
		
  		 if ((typeof(iconStr)=="undefined") || (iconStr==null)) { 
    		  iconStr = "red"; 
 		  }
  		 if (!icons[iconStr]) {
     		 icons[iconStr] = new google.maps.MarkerImage("http://www.google.com/mapfiles/marker"+ iconStr +".png",
     		 // This marker is 20 pixels wide by 34 pixels tall.
      		new google.maps.Size(20, 34),
      		// The origin for this image is 0,0.
     		 new google.maps.Point(0,0),
      		// The anchor for this image is at 6,20.
      		new google.maps.Point(9, 34));
  		 } 
 		  return icons[iconStr];

		}



	

	
