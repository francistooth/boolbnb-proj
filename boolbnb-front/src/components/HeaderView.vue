<script>
export default {
  name: "HeaderView",
}
</script>

<template>
    <div class="container-fluid bg bg-primary">
        <div class="navbar-expand-md">
            <div class="navbar-dark text-center my-2">
                <button class="navbar-toggler border rounded-2 border-opacity-50 p-1" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span> <span class="align-middle text-light">Menu</span>
                </button>
            </div>
            <div class="text-center my-3 collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav mx-auto ">
                    <li class="nav-item text-center">
                        <router-link class="nav-link" to="/"> home </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/team"> Chi siamo </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/contacts"> Contatti </router-link>
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
                </ul>
            </div>
        </div>
    </div>
</template>


<style lang="scss" scoped>
@use "../styles/general.scss" as *;
@use "../styles/partials/variables.scss" as *;

.container-fluid a {
    font-family: sans-serif;
    font-size: 1.1rem;
    text-transform: uppercase;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4)
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
</style>
