<template>
    <div>
        <b-row>
            <b-form-group 
                label-for="to-input"
                label-cols-sm="3"
                label-align-sm="right"
                >
                <template slot="label">{{$t('api_google_maps.lable.to')}}</template>
                <b-form-input
                    id="to-input"
                    v-model="location.origin">
                </b-form-input>
            </b-form-group>
            <b-form-group 
                label-for="from-input"
                label-cols-sm="3"
                label-align-sm="right"
                >
                <template slot="label">{{$t('api_google_maps.lable.from')}}</template>
                <b-form-input
                    id="from-input"
                    v-model="location.destination">
                </b-form-input>
            </b-form-group>
        </b-row>
        <b-container fluid>
            <iframe width="100%" height="500px" v-bind:src="clickMaps()" ></iframe>
        </b-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            location: {
                origin: "dubai",
                destination: "ajman"
            },
            location_compute: {
                prefix: "",
                postfix: ""
            },
            data: {},
            url: "https://www.google.com/maps/embed/v1/directions?key=AIzaSyDXXJNkagsiWrW6rFA5wMO4fxYCJmxXjMA"
        }
    },
    mounted() {
        this.updateLocation()
    },
    methods: {
        createLocation() {
            this.location_compute.prefix = '10.0025' + Math.floor(Math.random() * 10) + 1
            this.location_compute.postfix = '76.30058' + Math.floor(Math.random() * 10) + 1
            this.data.origin_new = this.location_compute.prefix + ',' + this.location_compute.postfix
            axios
                .post('/location', this.data)
                .then(response =>{
                    console.log(response)
                })
        },
        getLocation() {
            if (this.location.origin == this.location.destination) {
                // đơn hàng đã đến địa điểm
                return;
            }
            axios
                .get('/location')
                .then(response =>{
                    console.log(response)
                    this.location.origin = response.data.origin
                    this.location.destination = response.data.destination
                    console.log(this.location)
                })
                .catch(errror =>{
                    console.log(error)
                })
        },
        updateLocation() {
            let tmp = this
            setInterval(()=>{
                this.createLocation()
                // getLocation in database
                this.getLocation()
            },1000)
        },
        clickMaps() {
            // esp post location vào database 1s/lần
            // nếu origin != destination => vào controller cập nhật lại location 1s/lần
            return this.url + "&origin=" + this.location.origin + "&destination=" + this.location.destination
        }
    }
}
</script>