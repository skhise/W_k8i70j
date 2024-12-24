<x-app-layout>
    <style>
        #map{
            height:400px;
            width: 100%;
        }
        .custom-popup {
            display: none;
            position: absolute;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            max-width: 200px;
            z-index: 999;
        }
    </style>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Location</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Select Employee</label>
                                            <div class="d-flex">
                                                <select class="form-control mt-2 select2 p-2" name="filter_engineer"
                                                    id="filter_engineer">
                                                    <option value="" selected>Select Engineer</option>
                                                    @foreach ($employees as $employee)
                                                        <option value={{$employee->EMP_ID}}>{{$employee->EMP_Name}}</option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-primary ml-4 fetch_location" onclick="">Fetch</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                    <div id="popup" class="custom-popup"></div> <!-- Custom Popup -->

                                        <div id="map">

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    @section('script')
    <script>
        let map, geocoder, marker, center;

        function initMap() {
            // Default coordinates for India (approximate center)
            const defaultLat = 20.5937;
            const defaultLng = 78.9629;

            center = { lat: defaultLat, lng: defaultLng };

            // Initialize Google Map
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8, // Zoom level to show India or user location
                center: center,
            });

            // Initialize the geocoder
            geocoder = new google.maps.Geocoder();

            // Add marker at the center location
           
            // Reverse geocode to get the address
            geocodeLatLng(center.lat, center.lng);
            

        }
        function showPopup(position,address) {
            const popup = document.getElementById('popup');
            popup.innerHTML = address; // Update with dynamic data or custom message
            popup.style.display = 'block';

            // Convert the marker's LatLng to pixel coordinates on the map
            const projection = map.getProjection();
            const point = projection.fromLatLngToPoint(position);

            // Set the position of the popup
            popup.style.left = (point.x + 5) + 'px';  // Adjust for desired popup offset
            popup.style.top = (point.y - 50) + 'px';  // Adjust ft for proper positioning
        }

        // Hide the popup when mouse leaves the marker
        function hidePopup() {
            const popup = document.getElementById('popup');
            popup.style.display = 'none';
        }
        function geocodeLatLng(lat, lng) {
            const latLng = { lat: parseFloat(lat), lng: parseFloat(lng) };

            geocoder.geocode({ location: latLng }, function (results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        // Set the address in the #address element
                        marker = new google.maps.Marker({
                            position: center,
                            map: map,
                            title: ''
                        });

                        google.maps.event.addListener(marker, 'mouseover', function() {
                showPopup(marker.getPosition(),results[0].formatted_address);
            });

           google.maps.event.addListener(marker, 'mouseout', function() {
                hidePopup();
            });
                       
                    }
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuvDryGW3Khf9LjIpbxNc5tSv4jf3AjM0
&callback=initMap&libraries=places" async defer></script>

    <script>
        $(document).on('click', ".fetch_location", function () {
          var user = $("#filter_engineer option:selected").val();
          if(user!=""){
            $.ajax({
                    url: 'getlocation/' + user,  // Endpoint URL
                    type: 'GET',  // HTTP method
                    success: function(response) {
                        if (response.status) {
                            // Handle successful response, e.g., display location data
                            var location = response.location;
                            if(location != null) {
                                geocodeLatLng(location.last_lang,location.last_long);
                            } else {
                                showError("Location not synced yet.")
                            }
                            } else {
                            // Handle error response
                            
                            showError('Error fetching location data')
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        console.error('AJAX Error:', error);
                        showError('Error fetching location data')
                    }
                });
        
          } else{

          }
        });  
        function showError(message){
            Swal.fire({
                        title: 'Error!',
                        text: message,
                        dangerMode: true,
                        icon: 'warning',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    });
        }  
    </script>
    @stop
</x-app-layout>