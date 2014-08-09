function initialize(contact_content, gmap_zoom, latitude, longitude, gmap_color) {
    var styles = [{
            stylers: [{
                    hue: "#f5f4ee"
                }, {
                    saturation: -20
                }
            ]
        }, {
            featureType: "road",
            elementType: "geometry",
            stylers: [{
                    lightness: 100
                }, {
                    visibility: "simplified"
                }
            ]
        }, {
            featureType: "road.arterial",
            elementType: "geometry.fill",
            stylers: [  { lightness: -50 }, 
                        { saturation: 40 }, 
                        { hue: gmap_color }
                    ]
        }, {
            featureType: "road.arterial",
            elementType: "labels.text",
            stylers: [{
                    color: "#ffffff"
                }, {
                    weight: 2
                }
            ]
        }, {
            featureType: "poi",
            elementType: "all",
            stylers: [{
                    visibility: "off"
                }
            ]
        }, {
            featureType: "water",
            elementType: "geometry",
            stylers: [  { lightness: -20 }, 
                        { saturation: 20 }, 
                        { hue: gmap_color }
                    ]
        }, {
            elementType: "labels.text.stroke",
            stylers: [{
                    visibility: "simplified"
                }
            ]
        }
    ];
    var styledMap = new google.maps.StyledMapType(styles, {
        name: "Styled Map"
    });
    var myLatLng = new google.maps.LatLng(latitude, longitude);
    var mapOptions = {
        center: myLatLng,
        scrollwheel: false,
        disableDefaultUI: false,
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL,
            position: google.maps.ControlPosition.LEFT_TOP
        },
        zoom: parseInt(gmap_zoom),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var floatMap = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);
    floatMap.mapTypes.set('map_style', styledMap);
    floatMap.setMapTypeId('map_style');
    var marker = new google.maps.Marker({
        position: myLatLng,
        visible: false
    });
    marker.setMap(floatMap);
    var boxText = document.createElement("div");
    boxText.innerHTML = contact_content;
    
    var myOptions = {
        content: boxText,
        disableAutoPan: false,
        maxWidth: 0,
        pixelOffset: new google.maps.Size(40, -90),
        zIndex: null,
        boxStyle: {
            width: "350px",
            height: "160px"
        },
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        isHidden: false,
        pane: "floatPane",
        enableEventPropagation: false
    };
    var ib = new InfoBox(myOptions);
    ib.open(floatMap, marker);
    google.maps.event.addDomListener(window, 'resize', function () {
        window.setTimeout(function () {
            floatMap.panTo(marker.getPosition());
        }, 500);
    });
}



;(function ($) {

    //Clean spaces and line breaks
    jQuery.fn.htmlClean = function() {
        this.contents().filter(function() {
            if (this.nodeType != 3) {
                $(this).htmlClean();
                return false;
            }
            else {
                this.textContent = $.trim(this.textContent);
                return !/\S/.test(this.nodeValue);
            }
        }).remove();
        return this;
    }
    //Function to convert hex format to a rgb color
    function rgb2hex(rgb){
     rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
     return (rgb && rgb.length === 4) ? "#" +
      ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
      ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
      ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
    }

    function get_url_parameter(needed_param, gmap_url) {
        var sPageURL = gmap_url;
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++)  {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == needed_param) {
                return sParameterName[1];
            }
        }
    }


    //Include bellow independent scripts calls.


    $(document).ready(function(){
        var contact_html = $('.contact-info-wrapper').htmlClean().html();
        var gmap_link = $('.contact-info-wrapper').data('gmap-url');
        var accent_color = $('.contact-info-wrapper').data('gmap-color');
        var color = rgb2hex($('.accent-background').css("background-color"));
        $('.contact-info-wrapper').remove();

        //Parse the URL and load variables (ll = latitude/longitude; z = zoom)
        var gmap_variables = get_url_parameter('ll', gmap_link);
		if (gmap_variables == undefined) {
			var gmap_variables = get_url_parameter('sll', gmap_link);
		}
        var gmap_zoom = get_url_parameter('z', gmap_link);
		if (gmap_zoom == undefined) {
			gmap_zoom = 10;
		}
        var gmap_coordinates = gmap_variables.split(',');


        // Initialize the map
        initialize(contact_html, gmap_zoom, gmap_coordinates[0], gmap_coordinates[1], color);
    });
})(jQuery);

