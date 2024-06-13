<script setup>
import { onMounted, ref } from 'vue';
import AlertComponent from '../components/AlertComponent.vue'

let alertOptions = {
    alertTitle: ref(''),
    alertText: ref(''),
    alertSucess: ref(true),
    alertVisibility: ref(false),
}

let diaryText = ref('');
let loading = ref(true);

let formattedLoadedDay = new Date().toISOString().slice(0, 10)
let currentDate = new Date().toISOString().slice(0, 10);

onMounted(async () => {
    loadDiaryEntry(formattedLoadedDay);
})

//Carga el contenido del diario de hoy (o bien el contenido previamente escrito o cadena vacía)
async function loadDiaryEntry(dateToLoad) {
    let loadPost = {
        userToken: localStorage.getItem("userToken"),
        date: dateToLoad
    }

    try {
        const response = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/getDiaryEntry', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(loadPost)
        });

        const data = await response.json();
        diaryText.value = data.text;    //Si pones response.text lo coge como una función en vez de un atributo
    } catch (error) {
        alertOptions.alertVisibility.value = true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }

    loading.value = false;
}

//Guarda los datos escritos en el diario en la fecha seleccionada
const saveDiaryEntry = async () => {
    let diaryInfo = {
        userToken: localStorage.getItem("userToken"),
        date: formattedLoadedDay,
        text: diaryText.value
    }

    try {
        let response = await fetch('http://localhost/Proyecto/ProyectoFinalBakend/api/updateDiaryEntry', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(diaryInfo)
        });

        if(!response.ok){
            response = await response.json();
            alertOptions.alertVisibility.value = true;
            alertOptions.alertTitle.value = response.errorTitle;
            alertOptions.alertText.value = response.errorText;
            alertOptions.alertSucess.value = response.status;
        }
    } catch (error) {
        alertOptions.alertVisibility.value = true;
        alertOptions.alertTitle.value = "Error";
        alertOptions.alertText.value = "Ha ocurrido un error al intentar conectarse al servidor";
        alertOptions.alertSucess.value = false;
    }
}

//Cambia el dia a mostrar en el diario y comprueba que no supere la fecha actual
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
    <AlertComponent :alert-options="alertOptions"
        @hide-alert-box="() => { alertOptions.alertVisibility.value = false }" />
    <div>
        <div v-if="loading" id="diaryLogin">
            <p>Cargando diario...</p>
        </div>

        <div id="diary" v-else="loading">
            <div class="dateBlock">
                <img src="../assets/img/arrowRight.png" alt="arrow left" width="50px" height="50px"
                    style="transform: rotate(180deg);" @click="changeDay(-1)">
                <input class="diaryDate" type="date" v-model="formattedLoadedDay" :max="currentDate"><br>
                <img src="../assets/img/arrowRight.png" alt="arrow right" width="50px" height="50px"
                    @click="changeDay(1)">
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