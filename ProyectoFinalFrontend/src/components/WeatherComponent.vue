<script setup>
import { ref, watch } from 'vue';
import { defineProps } from 'vue';

const props = defineProps({
    city: String,
    date: String
});

const apiKey = '7a7fc674ccb250c106ae7d0744bfbcb6';
const forecasts = ref([]);
const averageWindSpeed = ref(0);
const averageRainProbability = ref(0);

const fetchWeatherData = async () => {
    try {
        let response = await fetch(`http://api.openweathermap.org/data/2.5/forecast?q=${props.city}&appid=${apiKey}&units=metric`);
        
        if (response.ok) {
            response = await response.json();
            // Ajustar el filtro para comparar solo la parte de la fecha
            const filteredForecasts = response.list.filter(forecast =>
                forecast.dt_txt.split(' ')[0] === props.date
            );

            if (filteredForecasts.length > 0) {
                const windSpeeds = filteredForecasts.map(forecast => forecast.wind.speed);
                averageWindSpeed.value = windSpeeds.reduce((a, b) => a + b, 0) / windSpeeds.length;

                const rainProbabilities = filteredForecasts.map(forecast => forecast.pop * 100);
                averageRainProbability.value = rainProbabilities.reduce((a, b) => a + b, 0) / rainProbabilities.length;

                forecasts.value = filteredForecasts.map(forecast => ({
                    date: forecast.dt_txt,
                    rainProbability: forecast.pop * 100,  // 'pop' es la probabilidad de precipitación
                }));
            } else {
                averageWindSpeed.value = 0;
                averageRainProbability.value = 0;
            }
        } else {
            console.log(`Error al obtener los datos metereológicos`);
        }
    } catch (error) {
        console.log(`Error al obtener los datos metereológicos`);
    }
};

watch(() => 
    [props.city, props.date], 
    fetchWeatherData, 
    { immediate: true }
);
</script>

<template>
    <div>
        <p>Prob. lluvia: {{ averageRainProbability }}%</p>
        <p>Media Viento: {{ averageWindSpeed.toFixed(1) }} m/s</p>
    </div>
</template>

<style scoped>
    
</style>
