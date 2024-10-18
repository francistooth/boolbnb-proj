<script>
import { store } from '../../store';
import Map from '../partials/Map.vue';
import axios from 'axios';


export default {
    name: "ApartmentCard",
    components: {
        Map
    },

    data() {
        return {
            store,
            apartment: {
                title: '',
                description: '',
                room: '',
                bed: '',
                bathroom: '',
                sqm: '',
                address: '',
                coordinate: '',
                img_path: '',
                img_name: '',
                is_visible: '',
                services: []
            }
        }

    }, methods: {
        getApi(slug) {

            axios.get(store.apiUrl + 'dettaglio/' + slug)
                .then(res => {
                    if (res.data.success) {

                        this.apartment = res.data.apartment;

                    } else {
                        console.log('errore 404');
                        this.$router.push({ name: '404' })
                    }

                })

        }
    },
    mounted() {
        const slug = this.$route.params.slug
        this.getApi(slug);
    }
}
</script>

<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-4 big-img">
                <img :src="apartment.img_path" :alt="apartment.img_name">
            </div>
            <div class="col-2"></div>
        </div>
        <div class="row mt-5">
            <div class="col-8 offset-2">
                <h4>{{ apartment.title }}</h4>
                <h5>Indirizzo:{{ apartment.address }}</h5>
                <p>{{ apartment.description }}</p>
                <ul>
                    <li>Letti : {{ apartment.bed }}</li>
                    <li>Bagni : {{ apartment.bathroom }}</li>
                    <li>Stanze : {{ apartment.room }}</li>
                    <li>Metri : {{ apartment.sqm }}</li>

                </ul>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-8 offset-2">
                <div class="divisor"></div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-8 offset-2">
                <div class="features">
                    Servizi aggiuntivi:
                    <div class="row">
                        <div class="col-3">
                            <ul class="lh-lg">
                                <li v-for="service in apartment.services">{{ service.name }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-8 offset-2">
                <div class="divisor"></div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-8 offset-2">
                <Map :cordinate="apartment" style="width: 500px; height:500px;" />
            </div>
        </div>
    </div>
</template>


<style lang="scss" scoped>
@use "../../styles/general.scss" as *;

.big-img {
    img {
        width: 100%;
    }
}

.divisor {
    height: 2.5px;
    background-color: black;
}

.features {
    font-size: 1.4rem;

    .row {
        font-size: 1rem;
    }
}

li {
    list-style: none;
}
</style>