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
        <div class="card d-flex align-items-center mb-2 p-2">
            <div class="row no-gutters ">
                <div class="col-sm-12 col-lg-auto  d-flex justify-content-center align-items-center pe-0">
                    <img :src="data.img_path" class="img-fluid" :alt="data.title" style="object-fit: cover;">
                </div>
                <div class="col ">
                    <div class="card-body row">
                        <h5 class=" col-8 card-title">{{ data.title }}</h5>
                        <div class="col-4 text-align-end"> <button v-if="data.sponsors.length > 0"
                                class="badge bg-success">Consigliato</button></div>
                        <small><span class="text-uppercase fw-bold">Indirizzo:</span> {{ data.address }} </small>
                        <small><span class="text-uppercase fw-bold">Distanza:</span> {{ Math.round(data.distance * 100)
                            / 100 }}Km</small>
                        <p class="card-text col-sm-12 col-md-6 col-lg-3 mb-0"><span
                                class="text-uppercase fw-bold">Stanze:</span> {{ data.room }}</p>
                        <p class="card-text col-sm-12 col-md-6 col-lg-3 mb-0"><span
                                class="text-uppercase fw-bold">Letti:</span> {{ data.bed }} </p>
                        <p class="card-text col-sm-12 col-md-6 col-lg-3 mb-0"><span
                                class="text-uppercase fw-bold">Bagni:</span> {{ data.bathroom }} </p>
                        <div class="dropdown d-sm-block d-md-none">
                            <button class="btn text-uppercase fw-bold dropdown-toggle p-0" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Servizi:
                            </button>
                            <ul class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3  overflow-hidden dropdown-menu">
                                <li div="col " v-for="service in data.services"><i :class="service.icon"></i>
                                    {{ service.name }}</li>
                            </ul>
                        </div>
                        <div class=" d-none d-md-block">
                            <p class="col-12 mb-0 "><span class="text-uppercase fw-bold ">Servizi:</span></p>
                            <ul class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3  overflow-hidden ">
                                <li class="col " v-for="service in data.services"><i :class="service.icon"></i>
                                    {{ service.name }}</li>
                            </ul>
                        </div>
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