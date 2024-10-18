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
    <div class="card" style="width: 18rem;">
        <img :src="data.img_path" class="card-img-top box-img" :alt="data.img_name">
        <div class="card-body">
            <h5 class="card-title">{{ data.title }}</h5>
            <p class="card-text">{{ data.address }}</p>
        </div>
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
</style>