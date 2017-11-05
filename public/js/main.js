var app = {};
app.markers = [];

function initMap() {
  app.map = new google.maps.Map(document.getElementById('map-canvas'), {
    center: {
      lat: -33.8688,
      lng: 151.2195,
      scrollwheel: false,
      zoomControl: false
    },
    zoom: 14
  });

  var input = /** @type {!HTMLInputElement} */ (
    document.getElementById('search-city'));

  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', app.map);

  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      window.alert("Autocomplete's returned place contains no geometry");
      return;
    }
    app.place = place;
  });
}

function getTweets(latLng) {
  clearMarkers();
  $.ajax({
    url: 'http://localhost:8000/map/tweets',
    method: "post",
    data: latLng
  })
  .done(function(data) {
    var _data = null;
    try {
      _data = JSON.parse(data);
      setMarkers(_data);
    } catch (e) {
      alert(e);
    }
  });
}

function clearMarkers(){
  if(app.markers.length > 0){
    app.infowindow.close();
    for (var i = 0; i < app.markers.length; i++) {
      if (app.markers[i]) {
        app.markers[i].setMap(null);
      }
    }
    app.markers = [];
  }
  
}

function setMarkers(_data) {
  app.infowindow = new google.maps.InfoWindow();
  $.each(_data.statuses, function(key, item) {
    var image = {
      url: item.profile_image_url || "img/marker.png",
      size: new google.maps.Size(64, 64),
      scaledSize: new google.maps.Size(48, 48),
      anchor: new google.maps.Point(24, 24)
    };
    // Add the marker at the clicked location
    if(item.geo != null ){
      app.markers[key] = new google.maps.Marker({
        position: new google.maps.LatLng(item.geo.coordinates[0], item.geo.coordinates[1]),
        icon: item.user.profile_image_url,
        title: item.user.name,
        animation: google.maps.Animation.DROP,
        map: app.map,
      });

      app.markers[key].desc = item.text;
      google.maps.event.addListener( app.markers[key], 'click', function() {
        app.infowindow.setContent(item.text+"<br>"+item.created_at);
        app.infowindow.open( app.map , this);
      });
      app.map.setZoom(14);
      app.map.setCenter(new google.maps.LatLng(item.geo.coordinates[0], item.geo.coordinates[1]));


      // Add circle overlay and bind to marker
      //Can be used for future
      //   var circle = new google.maps.Circle({
      //     map: app.map,
      //   radius: 16093,    // 10 miles in metres
      //   fillColor: '#AA0000'
      // });
      //   circle.bindTo('center', app.markers[key], 'position');


    }
  });
}

$(document).ready(function(){
  setTimeout(function(){
    initMap();
  }, 700);

  //Click event to show map on search map
  $("#search").on('click', function(e){
    e.preventDefault();
    $('#mapper_wrapper').show();
    $('#history_wrapper').hide();
    // If the place has a geometry, then present it on a map.
    if (app.place.geometry.viewport) {
      app.map.fitBounds(app.place.geometry.viewport);
    } else {
      app.map.setCenter(app.place.geometry.location);
      app.map.setZoom(14); // Why 17? Because it looks good.
    }
    getTweets({
      lat: app.place.geometry.location.lat(),
      lng: app.place.geometry.location.lng(),
      city: $('#search-city').val(),
      _token: $('#csrf').val()
    });
  });

  //Click event to show history page
  $('#search_history').on('click',function(e){
    e.preventDefault();
    $.ajax({
      url: 'http://localhost:8000/map/tweets_history',
      method: "get"
    })
    .done(function(response) {
      var data = $.parseJSON(response);
      try {
        var html = '<table class="table">\
        <thead>\
        <tr>\
        <th>SN</th>\
        <th>City</th>\
        </tr>\
        </thead>\
        <tbody>';

        $.each(data, function( index, value ) {
          var i = index+1;
          html += '<tr>\
          <th scope="row">'+i+'</th>\
          <td>'+value.keyword+'<span class="count">'+value.count+'</span></td>\
          </tr>';
        });
        html +='</tbody>\
        </table>';
        $('#mapper_wrapper').hide();
        $('#history_wrapper').show();
        $('#history').html(html);
      } catch (e) {
        alert(e);
      }
    });
  });

})
