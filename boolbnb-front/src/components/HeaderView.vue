<script>
export default {
    name: "HeaderView",
}
</script>

<template>
    <!--     <nav class="d-flex align-items-center ">
        <router-link :to="{ name: 'search' }">Ricerca Avanzata</router-link>
        <div class="dropdown ms-5">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Accedi
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="http://127.0.0.1:8001/login">Login</a></li>
                <li><a class="dropdown-item" href="http://127.0.0.1:8001/register">Registrati</a></li>
            </ul>
        </div>
    </nav>
 -->
    <div id="mainNavigation">
        <nav role="navigation">
            <div class="py-3 text-center border-bottom">
                <RouterLink to="/"><img src="./../assets/logo_sovversivo.png" width="75" height="75" class="invert" />
                </RouterLink>
            </div>
        </nav>
        <div class="navbar-expand-md">
            <div class="navbar-dark text-center my-2">
                <button class="navbar-toggler w-75" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span> <span class="align-middle">Menu</span>
                </button>
            </div>
            <div class="text-center mt-3 collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav mx-auto ">
                    <li class="nav-item">
                        <RouterLink to="/">home</RouterLink>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'search' }">Ricerca Avanzata</router-link>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Chi siamo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contatti</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            accedi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="http://127.0.0.1:8001/login">login</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8001/register">register</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>


<style lang="scss" scoped>
@use "../styles/general.scss" as *;

#mainNavigation a {
    font-family: 'Cabin', sans-serif;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4)
}

.dropdown-menu {
    background: #03727d
}

a.dropdown-toggle {
    color: #dfdfdf !important
}

a.dropdown-item:hover {
    color: #03727d !important
}

.nav-item a {
    color: #dfdfdf;
}

.nav-item a:hover {
    color: #fff
}

.nav-item {
    min-width: 12vw;
}

#mainNavigation {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 123;
    padding-bottom: 120px;
    /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#000000+0,000000+100&0.65+0,0+100;Neutral+Density */
    background: -moz-linear-gradient(top, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0) 100%);
    /* FF3.6-15 */
    background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0) 100%);
    /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0) 100%);
    /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#a6000000', endColorstr='#00000000', GradientType=0);
    /* IE6-9 */
}

#navbarNavDropdown.collapsing .navbar-nav,
#navbarNavDropdown.show .navbar-nav {
    background: #037582;
    padding: 12px;
}
</style>
