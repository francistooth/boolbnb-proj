<script>
export default {
    name: "HeaderView",
}
</script>

<template>
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
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/login">login</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/register">register</a></li>
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
    font-family: sans-serif;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4)
}

.dropdown-menu {
    background: (0, 0, 0, 0.3);
}

a.dropdown-toggle {
    color: #dfdfdf !important
}

a.dropdown-item:hover {
    color: #353a5085 !important
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
    top: 0;
    left: 0;
    width: 100%;
    z-index: 123;
    padding-bottom: 120px;
    background: -moz-linear-gradient(top, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0) 100%);
    background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0) 100%);
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#a6000000', endColorstr='#00000000', GradientType=0);
}

#navbarNavDropdown.collapsing .navbar-nav,
#navbarNavDropdown.show .navbar-nav {
    background: transparent;
    padding: 12px;
}
</style>
