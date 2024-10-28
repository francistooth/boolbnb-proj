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
    }
};

</script>
<template>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="search-container col-md-8">
            <div class="search">
                <input type="text" class="form-control" placeholder="cerca alloggi..." @keyup="getSuggest"
                    v-model="macroSearch">
                <button class="btn btn-primary text-white rounded" @click="searchCoordinate(macroSearch)">
                    <i class="fas fa-magnifying-glass"></i>
                </button>
                <ul class="list-group" v-if="this.suggests.length > 0">
                    <li class="list-group-item" v-for="suggest, index in suggests" :key="index">
                        <a href="#" @click="searchCoordinate(useSuggest(index))">{{ suggest.address.freeformAddress
                            }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@use "../../styles/partials/variables.scss" as *;

.search-container {
    min-height: 10vh;
    background-color: $primary_color;
    position: relative;
}

.search {
    position: absolute;
    max-width: 1100px;
    left: 50%;
    width: calc(100% - 50px);
    transform: translate(-50%, 55px);
    z-index: 2;

    input {
        height: 60px;
        text-indent: 25px;
        border: 3px solid $primary_color;
        backdrop-filter: blur(4px);

        &:focus {

            box-shadow: none;
            border: 3px solid white;
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

    button:hover {
        background-color: #0047a0;
    }
}
</style>