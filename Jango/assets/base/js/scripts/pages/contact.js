// CONTACT MAP

var PageContact = function() {

	var _init = function() {

		var mapbg = new GMaps({
			div: '#gmapbg',
			lat: 38.687852,
			lng: -0.783124,
			scrollwheel: true
		});


		mapbg.addMarker({
			lat: 38.687852,
			lng: -0.783124,
			title: 'Grafidel, S.L.',
			infoWindow: {
				content: '<h3>Grafidel, S.L.</h3><p>Vereda, 2 · Camp de Mirra (Alicante) España</p>'
			}
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
    PageContact.init();
});