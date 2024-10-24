<script>
export default {
    name: 'CardSearch',
    props: {
        data: Object
    },
    data() {
        return {

        }
    }
}
</script>

<template>
    <router-link :to="{ name: 'dettagli', params: { slug: data.slug } }">
        <div class="card mb-3 p-2">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img :src="data.img_path" class="card-img" :alt="data.title">
                </div>
                <div class="col-md-8">
                    <div class="card-body row">
                        <h5 class=" col-8 card-title">{{ data.title }}</h5>
                        <button v-if="data.sponsors.length > 0" class="col-4 badge bg-secondary">Consigliato</button>
                        <small> Indirizzo:{{ data.address }} <br>
                            Distanza :{{ Math.round(data.distance * 100) / 100
                            }}Km</small>
                        <p class="card-text"> N.stanze:{{ data.room }}</p>
                        <p class="card-text">N.letti:{{ data.bed }} </p>
                        <p class="card-text">N.bagni:{{ data.bathroom }} </p>
                        <ul class="row row-cols-2">
                            <li div="col" v-for="service in data.services"><i :class="service.icon"></i>{{ service.name
                                }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </router-link>
</template>

<style lang="scss" scoped>
img {
    width: 200px;
    height: 200px;
}

ul {
    list-style: none;


}
</style>