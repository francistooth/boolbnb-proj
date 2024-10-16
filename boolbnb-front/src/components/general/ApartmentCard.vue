<script>
import { store } from '../../store';

export default {
    name: "ApartmentCard",
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
    <div class="card ">
        <RouterLink to="/dettagli-appartamento"><img src="/img/glamp1.jpeg" class="card-img-top" alt="..."></RouterLink>
        <div class="card-body">
            <h5 class="card-title">{{ store.apartments.title }}</h5>
            <ul>
                <li>{{ store.apartments.address }}</li>
                <li>Letti:2</li>
                <li>Bagno:No</li>
                <li>Distanza dal centro Città</li>
            </ul>
        </div>
    </div>
</template>


<style lang="scss" scoped>
@use "../../styles/general.scss" as *;

ul {
    list-style: none;
}
</style>