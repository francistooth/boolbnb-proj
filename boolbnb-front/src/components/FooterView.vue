<template>
    <footer class="text-light ">
        <div class="container-fluid">
            <div class="row space-between align-items-center">
                <div class="col">
                    <div class="row d-flex justify-content-between align-content-center  pt-5 ">
                        <ul class="list-unstyled col text-nowrap ">
                            <li><a class="text-dark hover-primary" href="#"><strong> Support </strong></a></li>
                            <li><a class="text-dark hover-primary" href="#"> Help center </a></li>
                            <li><a class="text-dark hover-primary" href="#"> AI Help Desk 24/24 </a></li>
                        </ul>
                        <ul class="list-unstyled col text-nowrap mx-2">
                            <li><a class="text-dark hover-primary" href="#"><strong> Careers </strong></a></li>
                            <li><a class="text-dark hover-primary" href="#"> Lavora con noi </a></li>
                            <li><a class="text-dark hover-primary" href="#"> Internship </a></li>
                        </ul>
                        <ul class="list-unstyled col ">
                            <li><a class="text-dark hover-primary" href="#"><strong> Partners </strong></a></li>
                            <li><a class="text-dark hover-primary" href="#"> Partner help </a></li>
                            <li><a class="text-dark hover-primary" href="#"> Boolbnb partner </a></li>
                        </ul>
                        <div class="col d-flex justify-content-around flex-wrap ">
                            <div class="icon-circle cursor-pointer">
                                <i class="fa-brands fa-facebook"></i>
                            </div>
                            <div class="icon-circle cursor-pointer">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </div>
                            <div class="icon-circle cursor-pointer">
                                <i class="fa-brands fa-twitter"></i>
                            </div>
                            <div class="icon-circle cursor-pointer">
                                <i class="fa-brands fa-instagram"></i>
                            </div>
                            <div class="icon-circle cursor-pointer">
                                <i class="fa-brands fa-pinterest"></i>
                            </div>
                        </div>
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

.cursor-pointer {
    cursor: pointer;
}

.container {
    max-width: 1000px;
}

.hover-primary:hover {
    color: $primary_color;
}

footer {
    min-height: 70px;
    background-color: #f5f5f5;
    color: black;

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
            color: $primary_color;
            font-size: 16px;

            &:hover {
                color: gray;
            }
        }
    }
}
</style>