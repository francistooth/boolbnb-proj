<script>
import axios from 'axios';

export default {
    name: "searchbar",
    data() {
        return {
            macroSearch: '',
            apartments: [],
            lat: null,
            lon: null,
            suggests: [],
        }
    },
    methods: {
        searchCoordinate(city) {
            const cityName = this.macroSearch

            axios.get('https://api.tomtom.com/search/2/geocode/' + cityName + '.json?key=M9AeCjwAbvaw4tXTx63ReRmUuBtIbnoZ&countrySet=IT')
                .then(res => {
                    /*  console.log(res.data.results[0]) */
                    this.lat = res.data.results[0].position.lat;
                    this.lon = res.data.results[0].position.lon;
                    /* this.coordinateInput = lon + ', ' + lat; */
                    /* return this.searchApartment(lat, lon); */
                })
                .then(() => {
                    this.$router.push({
                        name: 'search',
                        params: {
                            address: String(this.macroSearch),
                            lat: String(this.lat),
                            lon: String(this.lon)
                        }
                    });
                })
                .catch(er => {
                    console.log(er.message);
                })
        },
        getSuggest() {
            if (this.macroSearch != '') {
                axios.get('https://api.tomtom.com/search/2/geocode/' + this.macroSearch + '.json?key=M9AeCjwAbvaw4tXTx63ReRmUuBtIbnoZ&storeResult=false&limit=5&countrySet=IT&view=Unified&json&minFuzzyLevel=1')
                    .then(result => {
                        console.log(result.data)
                        this.suggests = result.data.results;
                    })
            }
        },
        useSuggest(index) {
            this.macroSearch = this.suggests[index].address.freeformAddress;
            this.suggests = [];
        }
        /* searchApartment(lat, lon){
            const radius = 20;
            console.log('Lat:', lat, 'Lon:', lon, 'Radius:', radius);


            axios.post('http://localhost:8001/api/appartamenti-nel-raggio', {
                lat: lat,
                lon: lon,
                radius: radius
            })
            .then(response => {
                // Salva i risultati nel data
                this.apartments = response.data;
                console.log(response.data);  
            })
            .catch(error => {
                console.error("Errore durante la ricerca degli appartamenti:", error);
            });
        } */
    }
};

</script>
<template>
    <div class="back-img">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-8 d">
                <div class="search">
                    <input type="text" class="form-control" placeholder="cerca alloggi..." @keyup="getSuggest"
                        v-model="macroSearch">
                    <button class="btn btn-primary text-white" @click="searchCoordinate(macroSearch)"
                        v-if="macroSearch != ''">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <ul class="list-group" v-if="this.suggests.length > 0">
                        <li class="list-group-item" v-for="suggest, index in suggests" :key="index">
                            <a href="#" @click="useSuggest(index)">{{ suggest.address.freeformAddress }}</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</template>

<style lang="scss" scoped>
@use "../../styles/general.scss" as *;


.back-img {
    background-image: url('../../assets/jumbo.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    height: 60vh;
    width: 100%;
    position: relative;
    margin-top: -280px;


    .search {
        position: relative;
        box-shadow: 0 0 40px rgba(51, 51, 51, .1);
        margin-top: 250px;

        input {
            height: 60px;
            text-indent: 25px;
            border: 2px solid #353a5085;
            background-color: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(4px);

            &:focus {

                box-shadow: none;
                border: 2px solid;
            }
        }

        .fa-search {

            position: absolute;
            top: 20px;
            left: 16px;

        }

        button {
            position: absolute;
            top: 5px;
            right: 5px;
            height: 50px;
            width: 110px;

        }
    }
}
</style>