// CONTACT MAP

var PageContact2 = function() {

	var _init = function() {

		var mapbg = GMaps.createPanorama({
			el: '#gmapbg',
			lat: 38.687852,
			lng: -0.783124,
			scrollwheel: true
		});
	}

    return {
        //main function to initiate the module
        init: function() {

            _init();

        }

    };
}();

$(document).ready(function() {
    PageContact2.init();
});