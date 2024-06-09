<script setup>
import { RouterLink, RouterView } from 'vue-router'
import router from '../router/index.js'
import { onMounted, ref } from 'vue';
import AlertComponent from '../components/AlertComponent.vue'

let alertOptions = {
    alertTitle: ref(''),
    alertText: ref(''),
    alertSucess: ref(true),
    alertVisibility: ref(false),
}

const emit = defineEmits(['ChangeSection']);

let loadingImage=ref(true);
let userProfilePic=ref('');

onMounted(async ()=>{
    if(localStorage.getItem('userToken')==null || localStorage.getItem('userToken')=='null'){
        unlogUser()
    }     
    await loadProfilePic()
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

async function loadProfilePic(){
    loadingImage.value=true;
    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/getProfilePicture', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ userToken: localStorage.getItem("userToken") })
        });

        if (response.ok) {
            let loadedImage = await response.blob();
            loadedImage = URL.createObjectURL(loadedImage);
            userProfilePic.value = loadedImage;
        } else {
            userProfilePic.value = '../../public/FotoPerfil/user100.png';
        }
    } catch (error) {
        alertOptions.alertVisibility.value = true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }
    loadingImage.value=false;
}

</script>

<template>
    <AlertComponent :alert-options="alertOptions"
    @hide-alert-box="() => { alertOptions.alertVisibility.value = false }" />
    <header>
        <div class="navbar navbar-expand-lg navbar">
            <div class="container-fluid">
                <RouterLink to="/panel" class="navbar-brand"><img src="../assets/img/logoDailyDash.png" alt="Logo DailyDash" height="27px"></RouterLink >

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseNavbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="collapseNavbarContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <RouterLink to="/" class="nav-link">Inicio</RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink to="/panel" class="nav-link">Panel</RouterLink>
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
                            <img src="../../public/FotoPerfil/user32.png" alt="Foto de usuario" class="profilePic" v-if="loadingImage"/>
                            <img :src="userProfilePic" alt="Foto de usuario" class="profilePic" v-else>
                            <ul class="dropdown-menu" id="userOptDropdown">
                                <li>
                                    <a href="#" @click="unlogUser" class="dropdown-item">Desconectar</a>
                                </li>
                                <li>
                                    <a href="#" @click="()=>{ router.push('/perfil') }" class="dropdown-item">Perfil</a>
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