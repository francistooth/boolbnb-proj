<script>
import { store } from '../../store';
import Map from '../partials/Map.vue';

export default {
    name: "ApartmentCard",
    components: {
        Map
    },
    data() {
        return {
            store,
        }

    },
    mounted() {
        console.log(store);

    }
}
</script>

<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-4 big-img">
                <img src="/img/glamp1.jpeg" class="" alt="...">
            </div>
            <div class="col-4">
                <div class="d-flex justify-content-between pb-2">
                    <img src="/img/glamp1.jpeg" class="" alt="...">
                    <img src="/img/glamp1.jpeg" class="" alt="...">
                </div>
                <div class="d-flex justify-content-between">
                    <img src="/img/glamp1.jpeg" class="" alt="...">
                    <img src="/img/glamp1.jpeg" class="" alt="...">
                </div>

            </div>
            <div class="col-2"></div>
        </div>
        <div class="row mt-5">
            <div class="col-8 offset-2">
                <h4 class="">{{ store.apartments.title }}</h4>
                <p>{{ store.apartments.address }}</p>
                <p class="mt-4">{{ store.apartments.description }}</p>
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
                                <li>WiFi gratuito</li>
                                <li>Colazione inclusa</li>
                                <li>Parcheggio gratuito</li>
                            </ul>
                        </div>
                        <div class="col-3">
                            <ul class="lh-lg">
                                <li>Trasferimenti aeroportuali</li>
                                <li>Cancellazione gratuita</li>
                                <li>Aria condizionata</li>
                            </ul>
                        </div>
                        <div class="col-3">
                            <ul class="lh-lg">
                                <li>Lavanderia</li>
                                <li>Cucina attrezzata</li>
                                <li>TV via cavo/satellite</li>
                            </ul>
                        </div>
                        <div class="col-3">
                            <ul class="lh-lg">
                                <li>Piscina</li>
                                <li>Servizio di pulizia</li>
                                <li>Guide locali e mappe</li>
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
                <Map style="width: 500px; height:500px;" />
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