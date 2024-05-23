<script setup>
import { ref } from 'vue';
import HeaderComponent from './HeaderComponent.vue';

const username = ref('Antonio5000');

const editUsername = () => {
    // Logic to edit username
};

const changePassword = () => {
    // Logic to change password
};
</script>

<template>
    <HeaderComponent />
    <div id="profileMain">
        <div id="userProfilePicture"></div>
        <div id="userUsername">
            <input type="text" v-model="username"><br>
            <button @click="editUsername">Editar</button>
        </div>
        <div id="changePassword">
            <button @click="changePassword">Cambiar Contraseña</button>
        </div>
    </div>
</template>

<style scoped>
input {
    text-align: center;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
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
}

#userUsername {
    padding: 10px;
    border-radius: 4px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
}

button {
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    background-color: #c57600;
    color: white;
}

button:hover {
    background-color: #814900;
}
</style>
