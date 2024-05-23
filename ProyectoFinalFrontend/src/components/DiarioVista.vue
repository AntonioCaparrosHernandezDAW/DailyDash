<script setup>
import { ref } from 'vue';

let diaryText=ref('');
let loading = ref(true);

let formattedToday = new Date().toISOString().slice(0,10)
console.log("Prueba: ",formattedToday)

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

async function loadDiaryEntry(dateToLoad){
    let loadPost={
        idUser:await loadUserId(),
        date:dateToLoad
    }

    const respuesta = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/getDiaryEntry', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(loadPost)
    });

    if (respuesta.ok) {
        const data = await respuesta.json();
        diaryText.value=data.text;
    } else {
        console.error('Error en la petición:', respuesta.statusText);
    }
    
    loading.value=false;
}
loadDiaryEntry(formattedToday);

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
        console.error('Error en la petición:', respuesta.error);
    }
}

function changeDay(value){
    const auxDate = new Date(formattedToday)
    auxDate.setDate(auxDate.getDate() + (value))
    formattedToday= auxDate.toISOString().slice(0,10)
    document.querySelector(".diaryDate").value=formattedToday
    loadDiaryEntry(formattedToday)
}
</script>

<template>
    <div>
        <div v-if="loading" id="diaryLogin">
            <p>Cargando diario...</p>
        </div>

        <div id="diary" v-else="loading">
            <div class="dateBlock">
                <img src="./img/arrowLeft.png" alt="arrow left" width="50px" height="50px" @click="changeDay(-1)">
                <input class="diaryDate" type="date" v-model="formattedToday"><br>
                <img src="./img/arrowLeft.png" alt="arrow left" width="50px" height="50px" style="transform: rotate(180deg);" @click="changeDay(1)">
            </div>
            <textarea v-on:focusout="saveDiaryEntry" v-model="diaryText"></textarea>
        </div>
    </div>
</template>

<style scoped>
#diaryLogin{
    display: block;
    width: 200px;
    text-align: center;
    margin: auto;
    margin-top: 10dvh;
}

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