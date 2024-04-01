function initialize() {
  var input = document.getElementById('address');
  var autocomplete = new google.maps.places.Autocomplete(input);
  google.maps.event.addListener(autocomplete, 'place_changed', function () {
    var place = autocomplete.getPlace();
    // console.log(place.name);
    // document.getElementById('city').value = place.name;
    document.getElementById('longitude').value = place.geometry.location.lng();
    document.getElementById('latitude').value = place.geometry.location.lat();
    for(let i=1; i < place.address_components.length; i++){
        let mapAddress = place.address_components[i];
        console.log(mapAddress.types);
        if(mapAddress.long_name !=''){
          if(mapAddress.types[0] =="administrative_area_level_1"){
            //document.getElementById('state').value = mapAddress.long_name;
            }
            if(mapAddress.types[0] =="locality"){
              document.getElementById('city').value = mapAddress.long_name;
              }

            if(mapAddress.types[0] =="postal_code"){
                document.getElementById('post_code').value = mapAddress.long_name;
            }
            // if(mapAddress.types[0] == "country"){
            //     var country = document.getElementById('country');
            //     for (let i = 0; i < country.options.length; i++) {
            //         if (country.options[i].text == mapAddress.long_name.toUpperCase()) {
            //             country.value = i;
            //             break;
            //         }
            //     }
            // }
        }
    }
  });
}
google.maps.event.addDomListener(window, 'load', initialize);
