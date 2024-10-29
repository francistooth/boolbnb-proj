<script>
export default {
    name: "HeaderView",

}
</script>

<template>
    <div class="container-fluid">
        <!-- 
        <nav role="navigation">
            <div class="py-3 text-center border-bottom">
                <RouterLink to="/"><img src="./../assets/logo_sovversivo.png" width="75" height="75" class="invert" />
                </RouterLink>
            </div>
        </nav> 
        -->
        <div class="navbar-expand-md">
            <div class="navbar-dark text-center my-2">
                <button class="navbar-toggler border rounded-2 border-opacity-50 p-1" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span> <span class="align-middle text-light">Menu</span>
                </button>
            </div>
            <div class="text-center mt-3 collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav mx-auto ">
                    <li class="nav-item text-center">
                        <router-link class="nav-link" to="/"> home </router-link>
                    </li>
                    <li class="nav-item text-center">
                        <router-link class="nav-link" :to="{ name: 'search' }">Ricerca Avanzata</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link><a class="nav-link" href="#">Chi siamo</a></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link><a class="nav-link" href="#">Contatti</a></router-link>
                    </li>

                    <li class="nav-item dropdown d-flex justify-content-center">
                        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            accedi
                        </a>
                        <ul class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/login">Accedi</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/register">Registrati</a></li>
                        </ul>
                    </li>

                    <!-- <div
                        v-if="isGuest"
                        class="navbar-guest"
                    >
                    
                    </div>

                    <div
                        v-else
                        class="navbar-auth"
                    >
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/admin/">Il mio account</a>
                        </li>
                    </div> -->
                </ul>
            </div>
        </div>
    </div>
</template>


<style lang="scss" scoped>
@use "../styles/general.scss" as *;
@use "../styles/partials/variables.scss" as *;

.container-fluid {
    background: $primary_color;
    /* min-height: 10vh;
    max-height: 20vh; */
}

.container-fluid a {
    font-family: sans-serif;
    font-size: 1.1rem;
    text-transform: uppercase;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4)
}

a.dropdown-toggle {
    color: #dfdfdf !important
}

a.dropdown-item {
    color: gray !important
}

a.dropdown-item:hover {
    color: black !important
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
}
</style>
