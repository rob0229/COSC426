$(document).ready(function(){
	$(".icon-menu").on('click', function(){
		$(".slidemenu").animate({"left": "0"});
		$("body").animate({"left": "285"}, function(){
			$("body").css("overflow", "hidden");
		});
	});
	
	$(".icon-close").on('click', function(){
		$(".slidemenu").animate({"left": "-285"});
		$("body").animate({"left": "0"}, function(){
			$("body").css("overflow", "auto");
		});
	});
	
	$(".slidemenu > ul > li").on('click', function(){
		if($(this).hasClass("selected")){
			$(this).children("ul").slideUp();
			$(this).removeClass("selected");
		} else {
			$(this).addClass("selected");
			$(this).children("ul").slideDown();
		}
	});
	
	$(".menuBtn.selected").live('click', function(){
	});
});