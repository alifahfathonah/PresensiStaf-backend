@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Setup Lokasi Kampus</div>

                <form action="{{ route('update.entity', $entity->id) }}" method="post">
                    @csrf
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <div class="form-group">
                            <label for="radius">Radius (maks 80, min 40)</label>
                            <input type="tel" name="radius" id="radius" class="form-control" min="40" max="80" value="{{ $entity->radius }}">
                        </div>
                        <div class="form-group">
                            <label for="lat">Latitude</label>
                            {{-- <input type="text" name="lat" id="lat" class="form-control" readonly='readonly' value="-6.9498099999407135"> --}}
                            <input type="text" name="lat" id="lat" class="form-control" readonly='readonly' value="{{ $entity->lat }}">
                        </div>
                        <div class="form-group">
                            <label for="lng">Longitude</label>
                            {{-- <input type="text" name="lng" id="lng" class="form-control" readonly='readonly' value="107.6246018551329"> --}}
                            <input type="text" name="lng" id="lng" class="form-control" readonly='readonly' value="{{ $entity->lng }}">
                        </div>

                        <div id="map"></div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" value="Simpan" class="btn btn-primary mr-auto">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('MAPS_KEY') }}&libraries=places&callback=initMap">
</script>
<script>
    var map, autocomplete, circle;

    $(function(){
        @if(!isset($entity))
        $("#radius").val(40);
        @endif

        // initMap();
            
        $("#radius").on("keyup", function(e){
            let value = $(this).val();

            if(circle && parseInt(value) >= 40 && parseInt(value) <= 80){
                circle.setRadius(parseInt($(this).val()))
            }
        });

        $("#radius").on("blur", function(e){
            let value = $(this).val();

            if(circle && parseInt(value) < 40){
                circle.setRadius(parseInt(40))
            } else if(circle && parseInt(value) > 80){
                circle.setRadius(parseInt(80))
            }
        });

        $("#lat, #lng").on("keyup", function(e){
            // createCircle($("#lat").val(), $("#lng").val(), parseInt($("#radius").val()))
        });

        console.warn($("#lat").val(), $("#lng").val())
        createCircle($("#lat").val(), $("#lng").val(), $("#radius").val());
    });

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -6.957232502941183, lng: 107.6591986837783},
            zoom: 4,
            fullscreenControl: false
        });

        map.setCenter(new google.maps.LatLng($("#lat").val(), $("#lng").val()));
        map.setZoom(18);
    }

    function find(query, radius){
        if(circle){
            circle.setMap(null);
        }

        var request = {
            query: query,
            fields: ['name', 'geometry'],
        };

        service = new google.maps.places.PlacesService(map);

        service.findPlaceFromQuery(request, function(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                map.setCenter(results[0].geometry.location);
                map.setZoom(18);

                createCircle(results[0].geometry.location.lat(), results[0].geometry.location.lng(), radius)
                document.getElementById('lat').value = results[0].geometry.location.lat()
                document.getElementById('lng').value = results[0].geometry.location.lng()
            } else {
                alert("tidak ditemukan!")
            }
        });
    }

    function createCircle(lat, lng, radius){
        // Add circle overlay and bind to marker
        circle = new google.maps.Circle({
            fillColor: '#F7CEAC',
            fillOpacity: .6,
            strokeWeight: 2,
            strokeColor: '#FC781F',
            draggable: true,
            editable: true,
            map: map,
            center: new google.maps.LatLng(lat, lng),
            radius: parseInt(radius)
        });

        google.maps.event.addListener(circle, 'radius_changed', function (event) {
            let value = Math.floor(this.getRadius());

            document.getElementById('radius').value = value;

            if(circle && parseInt(value) < 40){
                circle.setRadius(parseInt(40));
            } else if(circle && parseInt(value) > 80){
                circle.setRadius(parseInt(80));
            }
        });

        google.maps.event.addListener(circle, 'center_changed', function (event) {
            document.getElementById('lat').value = this.getCenter().lat();
            document.getElementById('lng').value = this.getCenter().lng();
        });
    }
</script>
@endsection