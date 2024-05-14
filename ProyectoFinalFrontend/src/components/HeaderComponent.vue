<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
    <header>
        <div class="navbar navbar-expand-lg navbar">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">DailyDash</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseNavbarContent">
                    <span class="navbar-toggler-icon" />
                </button>

                <div class="collapse navbar-collapse" id="collapseNavbarContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <RouterLink to="/" class="nav-link">Inicio</RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink to="/panel" class="nav-link">Panel</RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink to="/" class="nav-link">Contacto</RouterLink>
                        </li>

                        <li class="nav-item dropdown" data-bs-toggle="dropdown">
                            <a href="#" class="nav-link dropdown-toggle">Funciones</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <RouterLink to="/perfil" class="dropdown-item">Notas</RouterLink>
                                </li>
                                <li>
                                    <RouterLink to="#" class="dropdown-item">Diario</RouterLink>
                                </li>
                                <li>
                                    <RouterLink to="#" class="dropdown-item">Calendario</RouterLink>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav me-auto" id="userOptUl">
                    <div id="userOptDiv">
                        <li class="nav-item dropdown" data-bs-toggle="dropdown">
                            <img src="./img/2.jpeg" width="30px" height="30px" />
                            <ul class="dropdown-menu" id="userOptDropdown">
                                <li>
                                    <RouterLink to="/login" class="dropdown-item">Desconectar</RouterLink>
                                </li>
                                <li>
                                    <RouterLink to="/perfil" class="dropdown-item">Perfil</RouterLink>
                                </li>
                                <li>
                                    <RouterLink to="#" class="dropdown-item">Opciones</RouterLink>
                                </li>
                            </ul>
                        </li>
                    </div>
                </ul>
                </div>
                
            </div>
        </div>
    </header>
    <RouterView/>
</template>

<style scoped>
#userOptDropdown{
    /*NO SIRVE EN TABLETS*/
    left: -6.7dvw;
    text-align: right;
}

#collapseNavbarContent{
    gap: 65dvw;
}

.navbar {
    background-color: var(--navbar);
    box-shadow: 0 1px 3px black;
}
</style>