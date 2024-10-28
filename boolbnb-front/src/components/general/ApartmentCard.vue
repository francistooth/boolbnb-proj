<script>
import Loader from '../partials/Loader.vue';

export default {
    name: "ApartmentCard",
    props: {
        data: Object
    },
    components: {
        Loader
    },
    data() {
        return {
            isLoaded: false
        }
    },
    methods: {
        imgLoad() {
            this.isLoaded = true;
        }
    },
    mounted() {
        const img = new Image();
        img.src = this.data.img_path;
        img.onload = this.imgLoad;
    }
}
</script>

<template>
    <router-link :to="{ name: 'dettagli', params: { slug: data.slug } }">
        <div v-if="isLoaded" class="card text-light d-flex justify-content-end align-items-center"
            :style="{ backgroundImage: 'url(' + data.img_path + ')' }">
            <div class="box text-center p-1">
                <h5 class="card-title">{{ data.title }}</h5>
            </div>
        </div>
        <Loader v-else/>
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
</style>
