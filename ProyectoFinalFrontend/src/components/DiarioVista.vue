<script setup>
import { ref } from 'vue';

let diaryText=ref('');
let loading = ref(true);

const today = new Date();
let yyyy = today.getFullYear();
let mm = today.getMonth() + 1;
let dd = today.getDate();

if (dd < 10) dd = '0' + dd;
if (mm < 10) mm = '0' + mm;

const formattedToday = yyyy+'-'+mm+'-'+dd;

async function loadUserId() {
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
            return data.userId.id
        } else {
            return 0;
        }
    } catch (error) {
        return 0;
    }
}

async function loadDiaryEntry(){
    let loadPost={
        idUser:await loadUserId(),
        date:formattedToday
    }
    console.log(loadPost)

    const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/getDiaryEntry', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(loadPost)
    });

    if (respuesta.ok) {
        console.log("Cargando los datos del usuario "+loadPost.idUser)
        const data = await respuesta.json();
        diaryText.value=data.text;
    } else {
        console.error('Error en la petición:', respuesta.statusText);
    }
    
    loading.value=false;
}
loadDiaryEntry();

const saveDiaryEntry = async ()=>{
    let diaryInfo={
        idUser:await loadUserId(),
        date:formattedToday,
        text:diaryText.value
    }

    const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/updateDiaryEntry', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(diaryInfo)
    });

    if (respuesta.ok) {
        const data = await respuesta.json();
        console.log(data)
    } else {
        console.error('Error en la petición:', respuesta.statusText);
    }
    
}
</script>

<template>
    <div>
        <div v-if="loading">
            <p>Cargando...</p>
        </div>

        <div id="diary" v-else="loading">
            <div class="dateBlock">
                <img src="./img/arrowLeft.png" alt="arrow left" width="50px" height="50px">
                <input class="diaryDate" type="date" v-bind:value="formattedToday"><br>
                <img src="./img/arrowLeft.png" alt="arrow left" width="50px" height="50px" style="transform: rotate(180deg);">
            </div>
            <textarea v-on:focusout="saveDiaryEntry" v-bind:value="diaryText">
            
            </textarea>
        </div>
    </div>
</template>

<style scoped>
h1 {
    text-align: center;
    margin: 5dvh 0px;
}

.dateBlock{
    width: 20dvw;
    display: flex;
    justify-content: space-around;
}

#diary {
    padding: 3%;
    outline: 1px solid green;
    width: 65dvw;
    height: 80dvh;
    margin: 7dvh auto;
    background-color: rgb(254, 227, 201);
    display: flex;
    flex-direction: column;
    align-items: center;

    & input{
        font-size: 30px;
        text-align: center;
    }

    & textarea {
        resize: none;
        width: 100%;
        height: 90%;
        background-color: rgb(254, 227, 201);
        border: 0px;
        padding: 0px;
    }

    & textarea:target{
        border: 0px;
    }
}
</style>