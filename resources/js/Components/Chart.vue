<script setup>
import { Chart, registerables } from "chart.js";
import { BarChart } from "vue-chart-3";
import { reactive, computed } from "vue";

const props = defineProps({
    'data' : Object,
})

const labels = computed(() => props.data.labels)
const totals = computed(() => props.data.totals)
const incomes = computed(() => props.data.incomes)
const outgoes = computed(() => props.data.outgoes)

Chart.register(...registerables);

const barData = reactive({
    labels: labels,
    datasets: [
        {
            label: '合計',
            data: totals,
            backgroundColor: "rgb(75, 192, 192)",
            tension: 0.1,
        },
        {
            label: '収入',
            data: incomes,
            backgroundColor: "rgb(129 140 248)",
            tension: 0.1,
        },
        {
            label: '支出',
            data: outgoes,
            backgroundColor: "rgb(248 113 113)",
            tension: 0.1,
        }
    ]
})

</script>

<template>
    <div v-show="props.data">
        <BarChart :chart-data="barData" />
    </div>
</template>
