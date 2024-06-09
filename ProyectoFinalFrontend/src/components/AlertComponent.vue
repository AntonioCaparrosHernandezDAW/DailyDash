<script setup>
import { ref, watch } from 'vue';
const emit = defineEmits(['hideAlertBox']);

//Valores iniciales
const props = defineProps({
    alertOptions: Object
});

//Valores iniciales modificables (defineProps los hace de solo lectura)
let alertBoxData = {
    alertTitle: ref(props.alertOptions.alertTitle.value),
    alertText: ref(props.alertOptions.alertText.value),
    alertSucess: ref(props.alertOptions.alertSucess.value),
    alertVisibility: ref(props.alertOptions.alertVisibility.value)
};

//Detecta si se hace algun cambio en los props y los recoge para actualizarlos
watch(props, (newProps) => {
    alertBoxData.alertTitle.value = newProps.alertOptions.alertTitle.value;
    alertBoxData.alertText.value = newProps.alertOptions.alertText.value;
    alertBoxData.alertSucess.value = newProps.alertOptions.alertSucess.value;
    alertBoxData.alertVisibility.value = newProps.alertOptions.alertVisibility.value;
});

//Emite @hide-alert-box para que se ejecute la función deseada por el componente padre
const hideAlertBox = () => {
    emit("hideAlertBox");
}
</script>

<template>
    <div id="alertBox" v-if="alertBoxData.alertVisibility.value" :style="{ backgroundColor: alertBoxData.alertSucess.value === true ? '#d4edda' : '#fdecea' }">
        <span class="close-btn" style="font-size: 30px; margin: -10px 5px 0px 0px;" @click="hideAlertBox">&times;</span>
        <h3>{{ alertBoxData.alertTitle.value }}</h3>
        <p>{{ alertBoxData.alertText.value }}</p>
    </div>
</template>

<style scoped>
#alertBox {
    position: absolute;
    border: 1px solid rgba(135, 135, 135, 0.507);
    padding: 20px;
    border-radius: 5px;
    width: 500px;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 5;
}

#alertBox .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}

p{
    margin: 0px;
}

.close-btn:hover {
    color: red;
}
</style>