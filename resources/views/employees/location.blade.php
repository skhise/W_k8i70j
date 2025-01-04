<x-app-layout>
    <style>
        #map {
            height: 70vh;
            width: 100%;
        }

        .custom-popup {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            display: none; /* Initially hidden */
            z-index: 1000;
            }

            .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            }

    </style>
    @php
        $api_key = env('OPENCAGE_API_KEY');
    @endphp
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
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Select Employee</label>
                                            <div class="d-flex">
                                                <select class="form-control mt-2 select2 p-2" name="filter_engineer"
                                                    id="filter_engineer">
                                                    <option value="">Select Engineer</option>
                                                    <option value="0" selected>All</option>
                                                    @foreach ($employees as $employee)
                                                        <option value={{$employee->EMP_ID}}>{{$employee->EMP_Name}}</option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-primary ml-4 fetch_location"
                                                    onclick="">Fetch</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                    <div id="popup" class="custom-popup">
                                    <button class="close-btn" onclick="closePopup()">x</button>
                                    <div id="popupText"></div>
                                    </div>

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
                zoom: 10, // Zoom level to show India or user location
                center: center,
            });

            // Initialize the geocoder
            geocoder = new google.maps.Geocoder();

            // Add marker at the center location

            // Reverse geocode to get the address
            geocodeLatLng("", "","","");


        }
        function showPopup(event, position, address,name,datetime) {
            const popup = document.getElementById('popup');
            var details = "<b>Name:</b>"+name+"<br/><b>Date:</b>"+datetime+"<br/>"+address;
            // popup.innerHTML = details; // Update with dynamic data or custom message
            popup.style.display = 'block';
            const popupText = document.getElementById('popupText');
            popupText.innerHTML = details;
            // Convert the marker's LatLng to pixel coordinates on the map
            const projection = map.getProjection();
            const point = projection.fromLatLngToPoint(position);
            // Get mouse position relative to the viewport
            const mousePosX = event.domEvent.clientX / 2;  // Offset to the right
            const mousePosY = event.domEvent.clientY / 2; // Offset above the cursor
            // alert(mousePosX+mousePosY);
            // Set the position of the popup to follow the mouse
            popup.style.left = mousePosX + parseInt(50) + 'px';
            popup.style.top = mousePosY +parseInt(70) + 'px';
            console.log('Mouse Position X:', mousePosX, 'Mouse Position Y:', mousePosY);

        }
      
            // Function to close the popup
            function closePopup() {
            const popup = document.getElementById('popup');
            popup.style.display = 'none';
            }
        // Hide the popup when mouse leaves the marker
        function hidePopup() {
            const popup = document.getElementById('popup');
            popup.style.display = 'none';
        }
        function geocodeLatLng(lat, lng,name,datetime) {
            const latLng = { lat: parseFloat(lat), lng: parseFloat(lng) };

            geocoder.geocode({ location: latLng }, function (results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        // Set the address in the #address element
                       const marker = new google.maps.Marker({
                            position: latLng,
                            map: map,
                            title: ''
                        });
                        // map.panTo(latLng);
                        markers.push(marker);
                        map.setZoom(5);
                        google.maps.event.addListener(marker, 'click', function (event) {
                            console.log(event);
                            showPopup(event, marker.getPosition(), results[0].formatted_address,name,datetime);
                        });

                        google.maps.event.addListener(marker, 'mouseout', function () {
                            // hidePopup();
                        });

                    }
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{$api_key}}
    &callback=initMap&libraries=places" async defer></script>

    <script>
        let markers = [];  // Global array to hold all markers

        function clearMarkers() {
            markers.forEach(function (marker) {
                marker.setMap(null);  // Remove each marker from the map
        });
    }
        function reloadMap() {
            clearMarkers();  // Remove existing markers

            // Reset map settings (this can also be done inside initMap if needed)
            const defaultLat = 20.5937;
            const defaultLng = 78.9629;

            const center = { lat: defaultLat, lng: defaultLng };

            // Reinitialize the map
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 20,
                center: center,
            });

            // Re-add markers (you can call your `geocodeLatLng` function here to add markers)
            // Example: geocodeLatLng(lat, lng, name, datetime);
        }
        function getLocation(){
            var user = $("#filter_engineer option:selected").val();
            var text = $("#filter_engineer option:selected").text();
            if (user != "") {

                if (user != 0) {
                    $.ajax({
                    url: 'getlocation/' + user,  // Endpoint URL
                    type: 'GET',  // HTTP method
                    success: function (response) {
                        if (response.status) {
                            // Handle successful response, e.g., display location data
                            var location = response.location;
                            if (location != null) {
                                reloadMap();
                                geocodeLatLng(location.last_lang, location.last_long,text,response.datetime);
                            } else {
                                showError("Location not synced yet.")
                            }
                        } else {
                            // Handle error response

                            showError('Error fetching location data')
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle AJAX error
                        console.error('AJAX Error:', error);
                        showError('Error fetching location data')
                    }
                });
                } else if (user == 0) {
                    $.ajax({
                    url: 'location-all/',  // Endpoint URL
                    type: 'GET',  // HTTP method
                    success: function (response) {
                        if (response.status) {
                            // Handle successful response, e.g., display location data
                            var location = response.location;
                            if (location != null) {
                                console.log(location);
                                location.forEach(element => {
                                    if(element.last_lang != null && element.last_long!=null){
                                        reloadMap();
                                        geocodeLatLng(element.last_lang, element.last_long,element.name,element.datetime);
                                    }
                                });
                                // 
                            } else {
                                showError("Location not synced yet.")
                            }
                        } else {
                            // Handle error response

                            showError('Error fetching location data')
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle AJAX error
                        console.error('AJAX Error:', error);
                        showError('Error fetching location data')
                    }
                });
                }
                

            }
        }
        $(document).on('click', ".fetch_location", function () {
                getLocation();
        });
        
        function showError(message) {
            Swal.fire({
                title: 'Error!',
                text: message,
                dangerMode: true,
                icon: 'warning',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
            });
        }  
        $(document).ready(function () {
            getLocation();
        });
    </script>
    @stop
</x-app-layout>