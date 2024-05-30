<script setup>
import { ref, watch, computed } from 'vue';
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

import { defineProps } from 'vue';

/*
const props = defineProps({
    cityName: {
        type: String,
        required: true,
    },
    selectedDate: {
        type: String,
        required: true
    }
});
*/
const props = {
    cityName: 'Madrid',
    selectedDate: '2024-05-27'
}

const apiKey = '7a7fc674ccb250c106ae7d0744bfbcb6';
const forecasts = ref([]);
const averageWindSpeed = ref(0);

const fetchWeatherData = async () => {
    try {
        const response = await fetch(`http://api.openweathermap.org/data/2.5/forecast?q=${props.cityName}&appid=${apiKey}&units=metric`);
        const data = await response.json();
        if (data.cod === '200') {
            //El fetch recoge los datos de 5 días si o si de modo que hay que filtrar
            const filteredForecasts = data.list.filter(forecast =>
                forecast.dt_txt.startsWith(props.selectedDate)
            );

            const windSpeeds = filteredForecasts.map(forecast => forecast.wind.speed);
            averageWindSpeed.value = windSpeeds.reduce((a, b) => a + b, 0) / windSpeeds.length;

            forecasts.value = filteredForecasts.map(forecast => ({
                date: forecast.dt_txt,
                rainProbability: forecast.pop * 100,  // 'pop' es la probabilidad de precipitación
            }));
        } else {
            console.error(`Error al obtener datos: ${data.message}`);
        }
    } catch (error) {
        console.error(`Error de red: ${error.message}`);
    }
};

watch(() => [props.cityName, props.selectedDate], fetchWeatherData, { immediate: true });

const chartData = computed(() => {
    return {
        labels: forecasts.value.map(forecast => forecast.date),
        datasets: [
            {
                label: 'Probabilidad de Lluvia (%)',
                backgroundColor: '#09f',
                data: forecasts.value.map(forecast => forecast.rainProbability),
            },
        ],
    };
});
</script>

<template>
    <div>
        <Bar :data="chartData"/>
        <p>Velocidad Promedio del Viento: {{ averageWindSpeed }} m/s</p>
    </div>
</template>

<style scoped>

</style>