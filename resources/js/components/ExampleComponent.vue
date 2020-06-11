<template>
    <div>
        <b-container fluid>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <progress_bar :dataInit="data"></progress_bar>
                    <div class="card">
                        <div class="card-header" style="width: 100%; height: 40px;"> Google API </div>
                        <div class="card-body">
                            <div id="api-maps" style="width: 100%; height: 470px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </b-container>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                map: null,
                marker: null,
                location: {},
                lineCoordinates: [],
                location_item: {
                    origin: {
                        lat: null,
                        lng: null
                    },
                    destination: {
                        lat: null,
                        lng: null
                    },
                    location_new: {
                        lat: null,
                        lng: null
                    },
                    status: null
                },
                data: {
                    status: null,
                    pickup: null,
                    code: null
                },
                dataUpdateLocation: {},
                visible_marker: false,
                action: {
                    id: this.data_init.id || null,
                    type: this.data_init.type || "none"
                },
                code: null,
                pickup: null
            }
        },
        props: {
            data_init: {
                type: [Array, Object],
                default() {
                    return {}
                }
            }
        },
        methods: {
            calculateAndDisplayRoute(directionsService, directionsRenderer) {
                directionsService.route({
                    origin: {lat: 37.77, lng: -122.447},  // Haight.
                    destination: {lat: 37.768, lng: -122.511},  // Ocean Beach.
                    travelMode: 'DRIVING'
                    }, function(response, status) {
                    if (status == 'OK') {
                        directionsRenderer.setDirections(response);
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                })
            },
            addMarker(location, map) {
                var icon = {
                    url: "http://maps.google.com/mapfiles/kml/paddle/red-stars.png", // url
                    scaledSize: new google.maps.Size(40, 40), // scaled size
                };
                var marker = new google.maps.Marker({
                position: location,
                map: map,
                icon: icon,
                draggable:true
                });
            },
            getCodeProduct() {
                axios
                    .get('/product', {params: this.action})
                    .then(response=>{
                        console.log("getProduct::::",response.data)
                        this.data.code = response.data[0].code;
                    })
                    .catch(err => {
                        console.log('')
                    })
            },
            initMap() {
                var icon = {
                    url: "http://maps.google.com/mapfiles/kml/shapes/ranger_station.png", // url
                    scaledSize: new google.maps.Size(40, 40), // scaled size
                };
                var icon_location_new = {
                    url: "http://maps.google.com/mapfiles/kml/paddle/grn-circle.png", // url
                    scaledSize: new google.maps.Size(40, 40), // scaled size
                };
                axios 
                    .get('/product', {params: this.action})
                    .then(response=> {
                        this.location_item = _.clone(response.data[0], true)
                        console.log("Location_item:::", this.location_item)
                        this.data.status = this.location_item.status
                        this.data.pickup = this.location_item.pickup
                        this.code = this.location_item.code
                        this.lineCoordinates.push(this.location_item.origin)
                        this.map = new google.maps.Map(document.getElementById('api-maps'), {
                            center: this.location_item.origin,
                            zoom: 8
                        })
                        this.marker = new google.maps.Marker({
                            map: this.map,
                            position: this.location_item.origin,
                            animation: "bounce",
                            icon: icon
                        })
                        this.newLocation = new google.maps.Marker({
                            map: this.map,
                            position: this.location_item.location_new,
                            icon: icon_location_new,
                            visible: this.visible_marker
                        })
                        this.addMarker(this.location_item.destination, this.map)
                        if (this.calcDistance(this.location_item.origin, this.location_item.location_new) == 0){
                            this.location = this.location_item.origin
                            this.visible_marker = false
                        }
                        else{
                            this.visible_marker = true
                            this.location = this.location_item.location_new
                            this.drawLine(this.location_item.location_new)
                        }
                        this.updateMap()

                    })
                    .catch(err => {
                        console.log('some things wrong in inItMap', err)
                    })
            },
            calcDistance(newLocation, destination) {
                var p1 = new google.maps.LatLng(newLocation.lat, newLocation.lng);
                var p2 = new google.maps.LatLng(destination.lat, destination.lng);
                return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
            },
            updateStatus() {
                console.log("Code::::",this.data.code);
                console.log("Action:::", this.action.type);
                if (this.data.code == null) {
                    return;
                }
                axios
                    .post('product', this.data)
                    .then(response =>{
                        console.log('update status success')
                    })
                    .catch(err=>{
                        console.log('update status faild ', err)
                    })
            },
            updateLocation() {
                if (this.data.code == null) {
                    return;
                }
                this.dataUpdateLocation.location_new = this.location.lat + ',' + this.location.lng
                this.dataUpdateLocation.code = this.data.code
                console.log("User_id:::::", this.dataUpdateLocation.code);
                axios
                    .post('/locationProduct', this.dataUpdateLocation)
                    .then(response => {
                        console.log('update location success')
                    })
                    .catch(err=>{
                        console.log('update location faild ', err)
                    })
            },
            drawLine(newLocation) {
                if (this.data.code == null || this.data.code == this.code) {
                    this.map.setCenter(newLocation)
                    this.newLocation.setPosition(newLocation)
                    this.newLocation.setVisible(this.visible_marker)
                    this.lineCoordinates.push(new google.maps.LatLng(newLocation.lat, newLocation.lng))
                    var lineCoordinatesPath = new google.maps.Polyline({
                        path: this.lineCoordinates,
                        geodesic: true,
                        map: this.map,
                        strokeColor: '#FF0000',
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    })
                }
            }, 
            updateMap() {
                if (this.data.code == this.code) {
                    this.data.pickup = this.pickup
                }
                let newLocation = {lat: this.location.lat, lng: this.location.lng}
                if (this.calcDistance(newLocation, this.location_item.origin) == 0) {
                    this.data.status = 0
                    this.visible_marker = false
                    this.updateStatus()
                    this.drawLine(newLocation)
                    return;
                }
                if(this.calcDistance(newLocation, this.location_item.destination) < 0.1 || this.data.status == 2) {
                    this.data.status = 2
                    this.visible_marker = false
                    this.updateStatus()
                    newLocation = this.location_item.destination
                    this.drawLine(newLocation)
                    return;
                }
                this.data.status = 1
                this.visible_marker = true
                this.updateStatus()
                this.drawLine(newLocation)
            },
        },
        mounted() {
            this.initMap()
        },
        created() {
            Echo.channel('location')
                .listen('SendLocation', (event) => {
                    this.location = event.location.location
                    this.pickup = event.location.pickup
                    this.data.code = event.location.code
                    switch(this.data.pickup){
                        case 1:
                            this.updateLocation()
                            this.updateMap()
                            break;
                        case 0:
                            this.updateMap()
                            break;
                    }
                })
        }
    }
</script>
