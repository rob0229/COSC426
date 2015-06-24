/*********************
controls.js
Programmer: Team "The Other Team" COSC 426 -SU
Date: January 28th 2015
Desc: Javascript controls
**********************/

function controls(){
	this.loadPage = function(){
			var _self = this;
			_self.properties();
			_self.homePage();
			_self.navbar();
			_self.adminPage();
			_self.hoverSpan();
			_self.message();
			_self.slideShow();
			_self.accountUpdatePage();
	}

	////////////////////////////////////
	// All controls for the navbar //
	////////////////////////////////////
	this.navbar = function(){
		var _self = this;
	}

	
	///////////////////////////
	// Popup messages
	///////////////////////////
	this.message = function(){
		$("#messageContainer").on('click', function(){
			$(this).fadeOut();
		});
	}
	
	/////////////////////
	// Slideshow
	/////////////////////
	this.slideShow = function(){
		var image;
		$.get("processors/getImageArray.php", function(e){
			images = JSON.parse(e);
			var num = Math.floor((Math.random() * images.length) + 1);
			$("#slideShow").css("background-image", "url('images/"+ images[num-1] +"')");
		});
		setInterval(function(){
			var num = Math.floor((Math.random() * images.length) + 1);
			$("#slideShow").css("background-image", "url('images/"+ images[num-1] +"')");
		}, 2000);
	}
	
	////////////////////////////////////
	// All controls for the home page //
	////////////////////////////////////
	this.homePage = function(){
		var _self = this;

		$.post("processors/getSessionVar.php", function(e){
			var result = JSON.parse(e);
		
			$("#tripName").val(result[0]);
			$("#destCity").val(result[1]);
			$("#startDate").val(result[2]);
			$("#endDate").val(result[3]);

		});

		$("#loadSavedTripBtn").on("click", function(){
			console.log("loadSavedTripBtn clicked");
			var tripID = $("#userTrips").val();
			console.log("trip ID is: " + $("#userTrips").val());
				window.location = "itinerary.php?tripID="+ tripID;
		});

		$("#loginBtn").on("click", function(){
			window.load("login.php");
		});


		$("#generateItinBtn").on("click", function(){

			//TODO: 'Check User Login!!!!!!!
			//TODO: Input Field Validation!!!!!!
			
				console.log("Generate Itinerary Button Clicked");
				var tripInfo = [$("#startDate").val(), $("#endDate").val(), $("#destCity").val(), $("#tripName").val()];
				var items = $('input:checkbox:checked').map(function () {
							  return this.value;
							}).get();
				console.log(tripInfo);
				console.log(items);
				$.post("processors/itineraryGenerator.php", {
					tripInfo: tripInfo,
					items: JSON.stringify(items)
				}, function(e){
					console.log("Result is " + e + ", ");
					var array = JSON.parse(e);
					console.log("New Trip ID is: "+array+", ");
					if(array[0] == -1){
						console.log(array[1]);
						$("#messageContainer").fadeIn();
						$("#messageContainer #message").html(array[1] + "<span>Click anywhere to make this message disappear</span>");
					} else {

						window.location = "itinerary.php?tripID="+ array;
					}
				});
			
		});
		

		/*-- Form Submit controls --*/
		$("#formSubmit").on("click", function(){

			if($("#endDate").val() != "" && $("#startDate").val() != "" && $("#tripName").val()!=""){
				if($("#startDate").val()  < $("#endDate").val()  ){
					$.get("processors/getEvents.php", {
						city: $("#destCity").val(),
						start: $("#startDate").val(),
						end: $("#endDate").val()
					}, function(e){
						$("#list").html(e);
						$('.container').animate({height:'toggle'},350, function(){
							$("#slideShow").css("display", "none");
							$("#loader").addClass("hidden");
							$("#formFields").css("display", "none");
							$(".container").animate({height:'toggle'}, 350, function(){
								$("#dropdownMenu").css("display", "inline");
							});
						});
					});
				}else{
					alert("Your start date must not be greater than end date.!!!");
				}
			}else{
				console.log("no startDate, or endDate, or TripName");
				$("#messageContainer").fadeIn();
				$("#messageContainer #message").html("Please enter in all information correctly<br/><span>Click anywhere to make this message disappear</span>");
			}
		});


		$("#formSubmitNotLoggedin").on("click", function(){
			console.log("submit not logged in clicked");

			$.post("processors/setSessionVar.php",{
				tripName: $("#tripName").val(),
				destCity: $("#destCity").val(),
				startDate: $("#startDate").val(),
				endDate: $("#endDate").val()
			});

			window.location = "login.php?action=mustLogIn";
		});

		$("#adminLink").on("click", function(){
			console.log("Clicked admin link");
			window.open("admin.php", "_self");
		});
		
		/*-- Activity Selection --*/
		$("#dropdownBackBtn").on('click', function(){
			$(".container").animate({height:'toggle'}, 350, function(){
				$("#formFields").css("display", "block");
				$("#dropdownMenu").css("display", "none");
				$(".container").animate({height:'toggle'},350);
			});
		});
		
		//category item list display
		$(".dropdown").on('click', function(){
			var cat = $(this).attr("data-cat");
			$(".list_sub").css("display", "none");
			$("#"+ cat).css("display", "block");
		});
	}

	this.hoverSpan = function(){
		$("#list span").live("click", function(){
			$.get("processors/getLocInfo.php", {
				loc: $(this).children("input").val(),
				startDate: $("#startDate").val(),
				endDate: $("#endDate").val()
			}, function(e){
				$("#desc").html(e);
			});
		});
	}
	
	/////////////////////////////////////////
	// All controls for the admin page //
	/////////////////////////////////////////
	this.adminPage = function(){
		var _self = this;

		$("#adminBackBtn").on("click", function(){
			console.log("Back Button Clicked");
			window.open("index.php", "_self");
		});
	}

	/////////////////////////////////////////
	// All controls for the admin page //
	/////////////////////////////////////////
	this.accountUpdatePage = function(){
		var _self = this;

		$(".userInfoDelete").on("click", function(){
			console.log("clicked delete for " + $(this).attr('id'));

			$.post("processors/deleteSavedTrip.php", {
				tripname: $(this).attr('id')
			}, function(e){
				console.log("results is " + e);
				window.open("accountinfo.php", "_self");
			});
		});
	}

	///////////////////////
	// GLOBAL PROPERTIES //
	///////////////////////
	this.properties = function(){
		var _self = this;
		//array that holds selected items
		_self.selectedItems = [];
		_self.wayptarray = [];
	}
	
	this.loadPage();

}