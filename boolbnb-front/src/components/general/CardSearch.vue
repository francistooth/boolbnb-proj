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
        <div class="card d-flex align-items-center w-75 mb-2 p-2">
            <div class="row no-gutters ">
                <div class="col-md-3 me-0 d-flex justify-content-center align-items-center">
                    <img :src="data.img_path" class="card-img" :alt="data.title">
                </div>
                <div class="col-md-7 ps-0">
                    <div class="card-body row">
                        <h5 class=" col-8 card-title">{{ data.title }}</h5>
                        <div class="col-4"> <button v-if="data.sponsors.length > 0"
                                class="badge bg-success">Consigliato</button></div>

                        <small> Indirizzo: {{ data.address }} </small>
                        <small>Distanza: {{ Math.round(data.distance * 100) / 100 }}Km</small>
                        <p class="card-text col-3 mb-0">Stanze: {{ data.room }}</p>
                        <p class="card-text col-3 mb-0">Letti: {{ data.bed }} </p>
                        <p class="card-text col-3 mb-0">Bagni: {{ data.bathroom }} </p>
                        <p class="col-12 mb-0">Servizi:</p>
                        <ul class="row row-cols-2">
                            <li div="col" v-for="service in data.services"><i :class="service.icon"></i> {{
                                service.name }}</li>
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