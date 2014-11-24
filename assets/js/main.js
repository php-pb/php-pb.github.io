$.fn.pressEnter = function(fn) {  

    return this.each(function() {  
        $(this).bind('enterPress', fn);
        $(this).keyup(function(e){
            if(e.keyCode == 13)
            {
              $(this).trigger("enterPress");
            }
        })
    });  
 }; 

$(function() {
	$('.search.input input').pressEnter(function() {
		var value = $(this).val();
		var url = '/search.html?';
		var param = 'description=';
		if (value.length > 0) {
			window.location.replace(url + param + value);
		}
	});
});