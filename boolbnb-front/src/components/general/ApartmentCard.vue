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
    <router-link :to="{ name: 'dettagli', params: { slug: data.slug } }">
        <div class="card text-light d-flex justify-content-end align-items-center"
            :style="{ backgroundImage: 'url(' + data.img_path + ')' }">
            <div class="box text-center p-1">
                <h5 class="card-title">{{ data.title }}</h5>

            </div>
        </div>
    </router-link>
</template>


<style lang="scss" scoped>
@use "../../styles/general.scss" as *;

.card {
    aspect-ratio: 5/6;
    overflow: hidden;
    background-size: cover;
    background-repeat: no-repeat;

    .box {
        width: 100%;
        background-color: rgba(0, 0, 0, 0.2);


    }


}

/* ................................ */
/* ul {
    list-style: none;
}

.box-img {
    width: 200px;
    height: 200px;

} */
</style>