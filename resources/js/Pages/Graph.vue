<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue'
import { getThisYear } from '@/common';
import { getThisMonth } from '@/common';
import axios from 'axios';
import Chart from '@/Components/Chart.vue';

onMounted(() => {
    form.year = getThisYear();
    form.month = getThisMonth();
})

const form = reactive({
    year: null,
    month: null,
})

const data = reactive({})

const getData = async() => {
    try {
        await axios.get('/api/daily', {
            params: {
                year: form.year,
                month: form.month,
            }
        })
        .then( res => {
            data.data = res.data.data
            data.labels = res.data.labels
            data.totals = res.data.totals
            data.incomes = res.data.incomes
            data.outgoes = res.data.outgoes
            // console.log(res.data);
        })
    } catch (e) {
        console.log(e.message)
    }
}

</script>

<template>
    <Head title="グラフ" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="getData">
                    年: <input type="number" name="year" v-model="form.year">
                    月: <input type="number" name="month" v-model="form.month">
                    <button class="mt-4 flex mx-auto text-white bg-indigo-500 border-0 py-2 sm:px-8 px-5 focus:outline-none hover:bg-indigo-600 rounded text-lg">選択した期間のグラフを表示する</button>
                    </form>

                    <Chart :data="data"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
