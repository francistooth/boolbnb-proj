<script>



export default {
    name: "ApartmentCard",
    props: {
        data: Object
    },
    data() {
        return {

        }

    },
    methods: {

    },

    mounted() {

    }
}
</script>

<template>
    <!-- <RouterLink to="/dettagli-appartamento"><img src="/img/glamp1.jpeg" class="card-img-top" alt="..."></RouterLink> -->
    <!--  <div class="card" style="width: 18rem;">
        <img :src="data.img_path" class="card-img-top box-img" :alt="data.img_name">
        <div class="card-body">
            <h5 class="card-title">{{ data.title }}</h5>
            <p class="card-text">{{ data.address }}</p>
        </div>
    </div> -->
    <div class="container">
        <!-- <section class="mx-auto my-5" style="max-width: 23rem;"> -->

        <div class="card booking-card v-2 mt-2 mb-4 rounded-bottom">
            <div class="bg-image hover-overlay ripple ripple-surface ripple-surface-light"
                data-mdb-ripple-color="light">
                <img :src="data.img_path" :alt="data.img_name" class="img-fluid">
            </div>
            <div class="card-body">
                <h4 class="card-title font-weight-bold">{{ data.title }}</h4>
                <p class="card-text">{{ data.address }}</p>
                <hr class="my-4">

            </div>
        </div>

        <!-- </section> -->
    </div>
</template>


<style lang="scss" scoped>
@use "../../styles/general.scss" as *;

ul {
    list-style: none;
}

.box-img {
    width: 200px;
    height: 200px;

}

body {
    background-color: #f5f7fa;
}

.card.booking-card.v-2 {
    background-color: #c7f2e3;
}

.card.booking-card.v-2 .fa {
    color: #f7aa00;
}

.card.booking-card.v-2 .card-body .card-text {
    color: #db2d43;
}

.card.card.booking-card.v-2 .chip {
    background-color: #87e5da;
}

.card.booking-card.v-2 .card-body hr {
    border-top: 1px solid #f7aa00;
}
</style>