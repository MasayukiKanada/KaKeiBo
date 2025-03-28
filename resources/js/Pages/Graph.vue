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

const table_form = reactive({
    category: null,
    partner: null,
})

const separateNum = num => {
    return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
}

const data = reactive({})

const getData = async() => {
    try {
        await axios.get('/api/chart', {
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

const table_data = reactive({})

const getTable = async() => {
    try {
        await axios.get('/api/table', {
            params: {
                category: table_form.category,
                partner: table_form.partner,
            }
        })
        .then( res => {
            table_data.total_budgets = res.data.total_budgets,
            table_data.monthly_total_budgets = res.data.monthly_total_budgets,
            table_data.year_list = res.data.year_list,
            table_data.month_list = res.data.month_list,
            table_data.all_total = res.data.all_total
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

                    <form @submit.prevent="getTable">
                        カテゴリ: <input type="number" name="category" v-model="table_form.category">
                        相手方: <input type="number" name="partner" v-model="table_form.partner">

                    <button id="chart-button" class="mt-6 mb-8 flex mx-auto text-white bg-indigo-400 border-0 py-2 sm:px-5 px-5 focus:outline-none hover:bg-indigo-500 rounded text-md">収支表を表示する</button>
                    </form>

                    <div class="mt-16 w-full mx-auto overflow-auto">
                        <div class="table-auto w-full text-left whitespace-no-wrap">
                            <div class="thead">
                                <div class="flex">
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 rounded-tl rounded-bl text-center">年／月</div>
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">収入</div>
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">支出</div>
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">合計</div>
                                </div>
                                <div class="flex bg-gray-50" v-if="table_data.all_total">
                                    <div class="w-1/4 px-4 py-3 text-center border-t-2 border-gray-100 text-gray-500 font-bold">累計</div>
                                    <div class="w-1/4 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(table_data.all_total.income) }}</div>
                                    <div class="w-1/4 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(table_data.all_total.outgo) }}</div>
                                    <div v-if="table_data.all_total.total > 0" class="w-1/4 px-4 py-3 text-right text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(table_data.all_total.total) }}</div>
                                    <div v-if="table_data.all_total.total < 0" class="w-1/4 px-4 py-3 text-right text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(Math.abs(table_data.all_total.total)) }}</div>
                                </div>
                            </div>

                            <div class="tbody hidden md:block">
                                <div v-for="total_budget in table_data.total_budgets" :key="total_budget.id">
                                    <div class="table_header flex flex-wrap accordion_button">
                                        <div class="w-1/4 px-4 py-3 text-center border-t-2 border-gray-100 text-gray-500 font-bold">{{ total_budget.year }}年</div>
                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.income) }}</div>
                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.outgo) }}</div>
                                        <div v-if="total_budget.income - total_budget.outgo > 0" class="w-1/4 px-4 py-3 text-right text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.income - total_budget.outgo) }}</div>
                                        <div v-if="total_budget.income - total_budget.outgo < 0" class="w-1/4 px-4 py-3 text-right text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(Math.abs(total_budget.income - total_budget.outgo)) }}</div>
                                    </div>

                                    <div class="table_body accordion_body">
                                        <div class="tbody monthly_table sm:overflow-x-auto overflow-x-scroll border-gray-100 bg-gray-100">
                                            <div v-for="monthly_total_budget in table_data.monthly_total_budgets">
                                                <div v-if="total_budget.year == monthly_total_budget.year">
                                                    <div v-if="monthly_total_budget.total[0] != null" class="flex">
                                                        <div class="w-1/4 px-4 py-3 text-center border-t-2 border-gray-100 text-gray-500 font-semibold">{{ monthly_total_budget.month }}月</div>
                                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(monthly_total_budget.total[0].income) }}</div>
                                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(monthly_total_budget.total[0].outgo) }}</div>
                                                        <div v-if="monthly_total_budget.total[0].income - monthly_total_budget.total[0].outgo > 0" class="w-1/4 px-4 py-3 text-right text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(monthly_total_budget.total[0].income - monthly_total_budget.total[0].outgo) }}</div>
                                                        <div v-if="monthly_total_budget.total[0].income - monthly_total_budget.total[0].outgo < 0" class="w-1/4 px-4 py-3 text-right text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(Math.abs(monthly_total_budget.total[0].income - monthly_total_budget.total[0].outgo)) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tbody md:hidden">
                                <details v-for="total_budget in table_data.total_budgets" :key="total_budget.id" class="details">
                                    <summary class="table_header flex flex-wrap details-summary">
                                        <div class="w-1/4 px-4 py-3 text-center border-t-2 border-gray-100 text-gray-500 font-bold">{{ total_budget.year }}年</div>
                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.income) }}</div>
                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.outgo) }}</div>
                                        <div v-if="total_budget.income - total_budget.outgo > 0" class="w-1/4 px-4 py-3 text-right text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.income - total_budget.outgo) }}</div>
                                        <div v-if="total_budget.income - total_budget.outgo < 0" class="w-1/4 px-4 py-3 text-right text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(Math.abs(total_budget.income - total_budget.outgo)) }}</div>
                                    </summary>

                                    <div class="table_body details-content">
                                        <div class="tbody monthly_table sm:overflow-x-auto overflow-x-scroll border-gray-100 bg-gray-100">
                                            <div v-for="monthly_total_budget in table_data.monthly_total_budgets">
                                                <div v-if="total_budget.year == monthly_total_budget.year">
                                                    <div v-if="monthly_total_budget.total[0] != null" class="flex">
                                                        <div class="w-1/4 px-4 py-3 text-center border-t-2 border-gray-100 text-gray-500 font-semibold">{{ monthly_total_budget.month }}月</div>
                                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(monthly_total_budget.total[0].income) }}</div>
                                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(monthly_total_budget.total[0].outgo) }}</div>
                                                        <div v-if="monthly_total_budget.total[0].income - monthly_total_budget.total[0].outgo > 0" class="w-1/4 px-4 py-3 text-right text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(monthly_total_budget.total[0].income - monthly_total_budget.total[0].outgo) }}</div>
                                                        <div v-if="monthly_total_budget.total[0].income - monthly_total_budget.total[0].outgo < 0" class="w-1/4 px-4 py-3 text-right text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(Math.abs(monthly_total_budget.total[0].income - monthly_total_budget.total[0].outgo)) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </details>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
