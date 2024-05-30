<script setup>
import { RouterLink, RouterView } from 'vue-router'
import router from '../router/index.js'
import { onMounted } from 'vue';

const emit = defineEmits(['ChangeSection']);

onMounted(()=>{
    if(localStorage.getItem('userToken')==null || localStorage.getItem('userToken')=='null'){
        unlogUser()
    }     
})

function changeSection(newSection) {
    localStorage.setItem('sectionLoad', newSection)
    emit("ChangeSection", newSection);
    router.push('/panel')
}

function unlogUser(){
    localStorage.setItem('sectionLoad', 'Notes')
    localStorage.setItem('userToken', null)
    localStorage.setItem('userEmail', null)
    router.push('/login')
}
</script>

<template>
    <header>
        <div class="navbar navbar-expand-lg navbar">
            <div class="container-fluid">
                <RouterLink to="/panel" class="navbar-brand">DailyDash</RouterLink >

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
                                    <a href="#" @click="() => { changeSection('Notes') }" class="dropdown-item">Notas</a>
                                </li>
                                <li>
                                    <a href="#" @click="() => { changeSection('Diary') }" class="dropdown-item">Diario</a>
                                </li>
                                <li>
                                    <a href="#" @click="() => { changeSection('Calendar') }" class="dropdown-item">Calendario</a>
                                </li>
                                <li>
                                    <a href="#" @click="() => { changeSection('ToDo') }" class="dropdown-item">Tareas</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav" id="userOptUl">
                    <div id="userOptDiv">
                        <li class="nav-item dropdown" data-bs-toggle="dropdown">
                            <img src="../../public/FotoPerfil/user32.png" class="profilePic" />
                            <ul class="dropdown-menu" id="userOptDropdown">
                                <li>
                                    <a href="#" @click="unlogUser" class="dropdown-item">Desconectar</a>
                                </li>
                                <li>
                                    <a href="#" @click="()=>{ router.push('/perfil') }" class="dropdown-item">Perfil</a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item">Opciones</a>
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
.profilePic{
    width: 32px;
    height: 32px;
    border: 1px solid black;
    border-radius: 50%;
    padding: 1px;
}

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