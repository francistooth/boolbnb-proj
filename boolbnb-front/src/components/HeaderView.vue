<script>
export default {
    name: "HeaderView",
}
</script>

<template>
    <nav class="d-flex align-items-center ">
        <router-link :to="{ name: 'search' }">Ricerca Avanzata</router-link>
        <router-link :to="{ name: 'try' }">Try</router-link>
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
</template>


<style lang="scss" scoped>
@use "../styles/general.scss" as *;

a {
    text-decoration: none;
    color: black;
    border: 1px solid black;
    border-radius: 12px;
    padding: 6px;
    background-color: rgb(177, 216, 252);
}
</style>
