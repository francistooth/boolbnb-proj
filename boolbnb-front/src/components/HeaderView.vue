<script>
export default {
    name: "HeaderView",
}
</script>

<template>
    <nav class="d-flex">
        <RouterLink to="/ricerca-avanzata">Cerca</RouterLink>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
</style>

