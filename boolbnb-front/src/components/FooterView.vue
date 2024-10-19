<template>
    <footer class="text-light position-relative">
        <div class="footer-bg-top-img"></div>
        <div class="container-fluid px-5">
            <div class="row space-between align-items-center">
                <div class="col">
                    <div class="row row-cols-1 row-cols-md-3 g-5 py-5 flex-nowrap
                    ">
                        <ul class="list-unstyled col text-nowrap ">
                            <li><a style="color: white;" href="#">Supporto clienti</a></li>
                            <li><a style="color: white;" href="#">Help center</a></li>
                            <li><a style="color: white;" href="#">Boolbnb center</a></li>
                        </ul>
                        <ul class="list-unstyled col text-nowrap mx-2">
                            <li><a style="color: white;" href="#">Newsroom</a></li>
                            <li><a style="color: white;" href="#">Careers</a></li>
                            <li><a style="color: white;" href="#">Lavora con noi</a></li>
                        </ul>
                        <ul class="list-unstyled col ">
                            <li><a style="color: white;" href="#">Partners</a></li>
                            <li><a style="color: white;" href="#">Clienti</a></li>
                            <li><a style="color: white;" href="#">Investitori</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col  flex-grow text-center small">
                    <i>Made whit &hearts;</i>

                </div>
                <div class="col d-flex justify-content-around ">
                    <div class="icon-circle">
                        <i class="fa-brands fa-facebook"></i>
                    </div>
                    <div class="icon-circle">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </div>
                    <div class="icon-circle">
                        <i class="fa-brands fa-twitter"></i>
                    </div>
                    <div class="icon-circle">
                        <i class="fa-brands fa-instagram"></i>
                    </div>
                    <div class="icon-circle">
                        <i class="fa-brands fa-pinterest"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: 'footer',
    data() {
        return {

        };
    },
};
</script>


<style scoped lang="scss">
@use '../styles/partials/_variables.scss' as *;

footer {
    margin-top: 290px;
    min-height: 70px;
    background-color: $background_footer;

    .footer-bg-top-img {
        position: absolute;
        top: -210px;
        background-image: url('../assets/footer01.png');
        background-position: center;
        background-size: cover;
        background-repeat: repeat-x;
        width: 100%;
        height: 210px;
    }

    .icon-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-around;

        &:hover {
            background-color: #ffffff;
        }

        i {
            color: $background_footer;
            font-size: 16px;

            &:hover {
                color: $primary_color;
            }
        }
    }
}
</style>