<script>
export default { name: "searchbar" };
</script>
<template>
    <div class="back-img">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-8 d">
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


.back-img {
    background-image: url('../../assets/jumbo.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    height: 60vh;
    width: 100%;
    position: relative;
    margin-top: -280px;


    .search {
        position: relative;
        box-shadow: 0 0 40px rgba(51, 51, 51, .1);
        margin-top: 250px;

        input {
            height: 60px;
            text-indent: 25px;
            border: 2px solid #353a5085;
            background-color: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(4px);

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
}
</style>