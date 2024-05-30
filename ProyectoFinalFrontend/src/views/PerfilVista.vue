<script setup>
import { onMounted, ref } from 'vue';
import HeaderComponent from '../components/HeaderComponent.vue';

let username = ref('');
let oldPassword = ref('')
let newPassword = ref('')
let confirmedPassword = ref('')

async function loadUsername() {
    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/getUserByToken', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ userToken: localStorage.getItem("userToken") })
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            username.value = data.username;
        } else {
            console.log("Ha ocurrido un error al cargar el usuario")
        }
    } catch (error) {
        console.error('Error en la petición:', error);
        failedUserRegisterAlertDisplay = "flex";
    }
}

const editUsername = async () => {
    const body = {
        userToken: localStorage.getItem("userToken"),
        newUsername: username.value
    }

    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/changeUsername', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            console.log("Respuesta: ", data)
        } else {
            console.log("Ha ocurrido un error al cargar las notas");
        }
    } catch (error) {
        console.error('Error al cargar las notas: ', error);
    }
};

const changePassword = async () => {
    const body = {
        userToken: localStorage.getItem("userToken"),
        oldPassword: oldPassword.value,
        newPassword: newPassword.value,
        confirmedPassword: confirmedPassword.value,
    }

    try {
        const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/changePassword', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (respuesta.ok) {
            const data = await respuesta.json();
            console.log("Respuesta: ", data)
        } else {
            console.log("Ha ocurrido un error al cambiar la contraseña del usuario");
        }
    } catch (error) {
        console.error('Error al conectar con el servidor: ', error);
    }
};

function clickImageManager(){
    console.log("click")
    document.getElementById('uploadImageInput').click();
}

let prueba= 'user100.jpg';

onMounted(() => {
    loadUsername();
})
</script>

<template>
    <HeaderComponent />
    <div id="profileMain">
        <div class="profileFunctions">
            <div id="userProfilePicture">
                <img v-bind:src="'../../public/FotoPerfil/'+prueba" alt="Foto de usuario" @click="clickImageManager">
            </div>
            <div id="userUsername">
                <input type="text" v-model="username">
                <button @click="editUsername">Editar Usuario</button>
            </div>
            <div id="changePassword">
                <input placeholder="Contraseña Actual" v-model="oldPassword" type="password">
                <input placeholder="Contraseña Anterior" v-model="newPassword" type="password">
                <input placeholder="Repetir Contraseña Anterior" v-model="confirmedPassword" type="password">
                <button @click="changePassword">Cambiar Contraseña</button>
            </div>
        </div>
    </div>
    <input type="file" id="uploadImageInput" hidden>
</template>

<style scoped>
input {
    text-align: center;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    padding: 5px 10px;
    border: 0px;
    border-radius: 4px;
    background-color: #d47f00;
    color: white;
}

#profileMain {
    width: 100vw;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: calc(100vh - 56px);
    padding: 5%;
    gap: 20px;
}

#userProfilePicture {
    border: 2px solid black;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    
    & img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
}

button:hover {
    background-color: #894f02;
}

.profileFunctions {
    width: 510px;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;

    & div {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 5dvh;
        gap: 0px;
    }
}
</style>
