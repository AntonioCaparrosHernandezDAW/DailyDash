<script setup>

</script>

<template>
    <header>
        <div class="navbar navbar-expand-lg navbar">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">Navbar</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseNavbarContent">
                    <span class="navbar-toggler-icon" />
                </button>

                <div class="collapse navbar-collapse" id="collapseNavbarContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <RouterLink to="#" class="nav-link">Inicio</RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink to="#" class="nav-link">Perfil</RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink to="#" class="nav-link">Contacto</RouterLink>
                        </li>

                        <li class="nav-item dropdown" data-bs-toggle="dropdown">
                            <a href="#" class="nav-link dropdown-toggle">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <RouterLink to="#" class="dropdown-item">Opción 1</RouterLink>
                                </li>
                                <li>
                                    <RouterLink to="#" class="dropdown-item">Opción 2</RouterLink>
                                </li>
                                <li>
                                    <RouterLink to="#" class="dropdown-item">Opción 3</RouterLink>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <form class="d-flex">
                        <input class="form-control" type="search" placeholder="Buscar...">
                        <button class="btn btn-success">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
</template>

<style scoped>
.navbar {
    background-color: var(--navbar);
    box-shadow: 0 1px 3px black;
}
</style>