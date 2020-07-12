<template>
    <div>
        <b-container fluid>
            <div class="row justify-content-center">
                <div class="mt-3 col-md-12">
                    <b-row>
                        <template v-if="data_init.type != 'view'">
                            <b-col class="slide-bar" cols="4">
                                <slide_bar_product :data_init="slide_init" @re-render="reRender"></slide_bar_product>
                            </b-col>
                            <b-col cols="8">
                                <progress_bar ref="progress_bar" :dataInit="data"></progress_bar>
                            </b-col>
                        </template>
                        <template v-else>
                            <b-col cols="12">
                                <progress_bar ref="progress_bar" :dataInit="data"></progress_bar>
                            </b-col>
                        </template>
                    </b-row>
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
                directionsRenderer: new google.maps.DirectionsRenderer({suppressMarkers: true}),
                directionsService: new google.maps.DirectionsService(),
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
                    code: null,
                    code_current: null
                },
                dataUpdateLocation: {},
                visible_marker: false,
                action: {
                    id: this.data_init.id || null,
                    type: this.data_init.type || "none"
                },
                code: null,
                pickup: null,
                icons: {
                    start: {
                        url: "http://maps.google.com/mapfiles/kml/paddle/grn-circle.png", // url
                        scaledSize: new google.maps.Size(40, 40), // scaled size
                    },
                    end: {
                        url: "http://maps.google.com/mapfiles/kml/paddle/red-stars.png", // url
                        scaledSize: new google.maps.Size(40, 40), // scaled size
                    }
                },
                marker_array: []
            }
        },
        props: {
            data_init: {
                type: [Array, Object],
                default() {
                    return {}
                }
            },
            slide_init: {
                type: [Array, Object],
                default() {
                    return {
                        name: "Loading..."
                    }
                }
            }
        },
        methods: {
            makeMarker( position, icon, title , visible) {
                this.marker_array.push(new google.maps.Marker({
                    position: position,
                    map: this.map,
                    icon: icon,
                    title: title,
                    visible: visible
                }));
            },
            clearMarkers() {
                for (var i = 0; i < this.marker_array.length-1; i++) {
                    this.marker_array[i].setMap(null);
                }
            },
            calculateAndDisplayRoute(directionsService, directionsRenderer, origin, destination) {
                let that = this;
                directionsService.route(
                    {
                        origin: {
                            lat: origin.lat,
                            lng: origin.lng
                        },
                        destination: {
                            lat: destination.lat,
                            lng: destination.lng
                        },
                        travelMode: google.maps.TravelMode["DRIVING"]
                    },
                    function(response, status) {
                        if (status == "OK") {
                            directionsRenderer.setDirections(response);
                            let leg = response.routes[0].legs[0];
                            var location_tmp = {
                                lat: leg.start_location.lat(),
                                lng: leg.start_location.lng()
                            }
                            if (that.calcDistance(location_tmp, that.location_item.origin) == 1.41) {
                                that.makeMarker( leg.start_location, that.icons.start, "origin" , false);
                            }
                            else {
                                that.makeMarker( leg.start_location, that.icons.start, "shipping" , true);
                            }
                            that.makeMarker( leg.end_location, that.icons.end, "destination", true);
                        } else {
                            window.alert("Directions request failed due to " + status);
                        }
                    }
                );
            },
            getCodeProduct() {
                axios
                    .get('/product', {params: this.action})
                    .then(response=>{
                        this.data.code = response.data.code;
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
                        this.location_item = _.clone(response.data, true)
                        this.slide_init.name = this.location_item.name
                        this.data.status = this.location_item.status
                        this.data.pickup = this.location_item.pickup
                        this.$refs["progress_bar"].updateProgressBar();
                        this.data.code_current = this.location_item.code
                        this.code = this.location_item.code
                        this.lineCoordinates.push(this.location_item.origin)
                        this.map = new google.maps.Map(document.getElementById('api-maps'), {
                            center: this.location_item.origin,
                            zoom: 20
                        })
                        this.directionsRenderer.setMap(this.map);
                        this.calculateAndDisplayRoute(this.directionsService, this.directionsRenderer, 
                                                        this.location_item.origin, this.location_item.destination);
                        this.marker = new google.maps.Marker({
                            map: this.map,
                            position: this.location_item.origin,
                            animation: "bounce",
                            icon: icon
                        })
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
                    // this.map.setCenter(newLocation)
                    this.clearMarkers();
                    this.calculateAndDisplayRoute(this.directionsService, this.directionsRenderer, 
                                                        newLocation, this.location_item.destination);
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
            reRender(item) {
                this.$parent.reRender(item);
            }
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
