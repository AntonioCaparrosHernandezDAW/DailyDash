<script setup>
import { ref } from 'vue';

let diaryText=ref('');
let loading = ref(true);

let formattedLoadedDay = new Date().toISOString().slice(0,10)
let currentDate = new Date().toISOString().slice(0, 10);

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
            return data.userId
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
loadDiaryEntry(formattedLoadedDay);

const saveDiaryEntry = async ()=>{
    let diaryInfo={
        idUser:await loadUserId(),
        date:formattedLoadedDay,
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

function changeDay(value) {
    const auxDate = new Date(formattedLoadedDay);
    auxDate.setDate(auxDate.getDate() + value);

    if (auxDate.toISOString().slice(0, 10) > currentDate) {
        return;
    }

    formattedLoadedDay = auxDate.toISOString().slice(0, 10);
    document.querySelector(".diaryDate").value = formattedLoadedDay;
    loadDiaryEntry(formattedLoadedDay);
}
</script>

<template>
    <div>
        <div v-if="loading" id="diaryLogin">
            <p>Cargando diario...</p>
        </div>

        <div id="diary" v-else="loading">
            <div class="dateBlock">
                <img src="../assets/img/arrowRight.png" alt="arrow left" width="50px" height="50px" style="transform: rotate(180deg);" @click="changeDay(-1)">
                <input class="diaryDate" type="date" v-model="formattedLoadedDay" :max="currentDate"><br>
                <img src="../assets/img/arrowRight.png" alt="arrow right" width="50px" height="50px" @click="changeDay(1)">
            </div>
            <textarea v-on:focusout="saveDiaryEntry" v-model="diaryText"></textarea>
        </div>
    </div>
</template>

<style scoped>
#diaryLogin {
    display: block;
    width: 200px;
    text-align: center;
    margin: auto;
    margin-top: 10vh;
}

h1 {
    text-align: center;
    margin: 5vh 0;
}

.dateBlock {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
}

.dateBlock img {
    cursor: pointer;
}

#diary {
    padding: 3%;
    border: 1px solid #ccc;
    border-radius: 8px;
    width: 60vw;
    height: 70vh;
    margin: 10vh auto;
    background-color: #fef0e3;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
}

#diary input {
    font-size: 20px;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
}

#diary textarea {
    resize: none;
    width: 100%;
    height: 80%;
    background-color: #fef0e3;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    font-size: 16px;
    box-sizing: border-box;
}

#diary textarea:focus {
    outline: none;
    border-color: #ffb74d;
    background-color: #fff;
}

#diary textarea::placeholder {
    color: #aaa;
}
</style>