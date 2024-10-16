<script>
export default {
    name: "FooterView",
}
</script>

<template>
    <div class="d-flex justify-content-between px-4 align-items-center">
        <div class="text-start ">
            <p>2024 BoolBnB International Inc. All rights reserved.</p>
            <ul class="d-flex ps-0">
                <li class="me-1">Term</li>
                <li class="mx-2">Site Map</li>
                <li class="">Privacy</li>
                <li class="ms-1">Privacy Choices</li>
            </ul>
        </div>
        <div>
            <i class=" fa-brands fa-facebook me-1"></i>
            <i class="fa-brands fa-instagram mx-2"></i>
            <i class="fa-brands fa-twitter mx-2"></i>
            <i class="fa-brands fa-pinterest ms-1 "></i>
        </div>
    </div>
</template>


<style lang="scss" scoped>
@use "../styles/general.scss" as *;

ul {
    list-style: none;

    li {
        border-radius: 25px;
        padding: 2px;

        &:hover {
            border-bottom: 1px solid red;
        }
    }
}

i {
    font-size: x-large;

    &:hover {
        filter: drop-shadow(5px 2px 2px grey);
    }
}
</style>