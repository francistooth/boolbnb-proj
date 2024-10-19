<script>
export default { name: "searchbar" };
</script>
<template>
    <div class="container">
        <div class="row height d-flex justify-content-center align-items-center">
            <div class="col-md-8">

                <div class="search">
                    <input type="text" class="form-control" placeholder="cerca alloggi...">
                    <button class="btn btn-primary text-white">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>

<style lang="scss" scoped>
@use "../../styles/general.scss" as *;



.search {
    position: relative;
    box-shadow: 0 0 40px rgba(51, 51, 51, .1);

    input {
        height: 60px;
        text-indent: 25px;
        border: 2px solid #d6d4d4;

        &:focus {

            box-shadow: none;
            border: 2px solid;
        }
    }

    .fa-search {

        position: absolute;
        top: 20px;
        left: 16px;

    }

    button {
        position: absolute;
        top: 5px;
        right: 5px;
        height: 50px;
        width: 110px;

    }
}
</style>