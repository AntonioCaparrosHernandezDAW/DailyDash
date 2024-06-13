<script setup>
import { onMounted, ref } from 'vue';
import HeaderComponent from '../components/HeaderComponent.vue';
import AlertComponent from '../components/AlertComponent.vue'

let alertOptions = {
    alertTitle: ref(''),
    alertText: ref(''),
    alertSucess: ref(true),
    alertVisibility: ref(false),
}

let username = ref('');
let oldPassword = ref('')
let newPassword = ref('')
let confirmedPassword = ref('')
let userProfilePic = ref('user100.png');
let loadingImage = ref(false);

//Función necesaria para cargar en el perfil el nombre de usuario mediante una llamada al servidor
async function loadUsername() {
    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/getUserByToken', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ userToken: localStorage.getItem("userToken") })
        });

        if (response.ok) {
            const data = await response.json();
            username.value = data.username;
        } else {
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.errorTitle;
            alertOptions.alertText.value = response.errorText;
            alertOptions.alertSucess.value = response.status;
        }
    } catch (error) {
        alertOptions.alertVisibility.value=true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }
}

//Contacta con el servidor para realizar la modificación del nombre de usuario y muestra el resultado por pantalla
const editUsername = async () => {
    const body = {
        userToken: localStorage.getItem("userToken"),
        newUsername: username.value
    }

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/changeUsername', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if(response.ok){
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.responseTitle;
            alertOptions.alertText.value = response.responseText;
            alertOptions.alertSucess.value = response.status;
        } else {
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.errorTitle;
            alertOptions.alertText.value = response.errorText;
            alertOptions.alertSucess.value = response.status;
        }
    } catch (error) {
        alertOptions.alertVisibility.value=true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }
};

//Contacta con el servidor para realizar la modificación de la contraseña y muestra el resultado por pantalla
const changePassword = async () => {
    const body = {
        userToken: localStorage.getItem("userToken"),
        oldPassword: oldPassword.value,
        newPassword: newPassword.value,
        newPassword_confirmation: confirmedPassword.value,
    }

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/changePassword', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (response.ok) {
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.responseTitle;
            alertOptions.alertText.value = response.responseText;
            alertOptions.alertSucess.value = response.status;
        } else {
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.errorTitle;
            alertOptions.alertText.value = response.errorText;
            alertOptions.alertSucess.value = response.status;
        }
    } catch (error) {
        alertOptions.alertVisibility.value=true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }

    oldPassword.value = oldPassword.value;
    newPassword.value = newPassword.value;
    newPassword_confirmation.value = confirmedPassword.value;
};

//Función intermedia para que se abra el input de introducir imagen
function clickImage(){
    document.getElementById('uploadImageInput').click();
}

//Guarda la imagen introducida por el usuario en el servidor con un nombre asociado al mismo
async function changeImage(event){
    const imagen = event.target.files[0]

    const body = new FormData();
    body.append('profilePic', imagen);
    body.append('userToken', localStorage.getItem("userToken"));

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/changeProfilePicture', {
            method: 'POST',
            body: body
        });

        if (response.ok) {
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.responseTitle;
            alertOptions.alertText.value = response.responseText;
            alertOptions.alertSucess.value = response.status;
        } else {
            response = await response.json();
            alertOptions.alertVisibility.value=true;
            alertOptions.alertTitle.value = response.errorTitle;
            alertOptions.alertText.value = response.errorText;
            alertOptions.alertSucess.value = response.status;
        }
    } catch (error) {
        alertOptions.alertVisibility.value=true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }

    loadProfilePic();
}

//Recoge los datos de la imagen desde el servidor y la muestra donde sea requerido
async function loadProfilePic(){
    loadingImage.value=true;
    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBackend/api/getProfilePicture', {
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
        alertOptions.alertVisibility.value=true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
        userProfilePic.value = '../../public/FotoPerfil/user100.png';
    }
    loadingImage.value=false;
}

onMounted(async () => {
    loadUsername();
    await loadProfilePic();
})
</script>

<template>
    <AlertComponent :alert-options="alertOptions" @hide-alert-box="()=>{ alertOptions.alertVisibility.value = false }" />

    <HeaderComponent />
    <div id="profileMain">
        <div class="profileFunctions">
            <div id="userProfilePicture" v-if="!loadingImage">
                <img :src="userProfilePic" alt="Foto de usuario" @click="clickImage">
            </div>
            <div v-else>
                <p>Cargando foto de perfil...</p>
            </div>
            <div id="userUsername">
                <input type="text" v-model="username">
                <button @click="editUsername">Editar Usuario</button>
            </div>
            <div id="changePassword">
                <input placeholder="Contraseña Actual" v-model="oldPassword" type="password">
                <input placeholder="Nueva Contraseña" v-model="newPassword" type="password">
                <input placeholder="Nueva Repetir Contraseña" v-model="confirmedPassword" type="password">
                <button @click="changePassword">Cambiar Contraseña</button>
            </div>
        </div>
    </div>
    <input type="file" id="uploadImageInput" hidden @change="changeImage" accept="image/*">
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
