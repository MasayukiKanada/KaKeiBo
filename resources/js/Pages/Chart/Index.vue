<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted, computed } from 'vue'
import { getThisYear } from '@/common';
import { getThisMonth } from '@/common';
import axios from 'axios';
import Chart from '@/Components/Chart.vue';
// import '@/accordion';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    all_total: Object,
    total_budgets : Object,
    monthly_total_budgets : Object,
    year_list: Object,
    month_list: Object,
    categories: Object,
    partners: Object,
});

const separateNum = num => {
    return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
}

onMounted(() => {
    form.year = getThisYear();
    form.month = getThisMonth();
})

const form = reactive({
    year: null,
    month: null,
    category_id: null,
    partner_id: null,
})

const data = reactive({})

const getData = async() => {
    if(form.year === null) {
        form.month = null
    }

    try {
        await axios.get('/api/chart', {
            params: {
                year: form.year,
                month: form.month,
                category_id: form.category_id,
                partner_id: form.partner_id,
            }
        })
        .then( res => {
                data.data = res.data.data
                data.labels = res.data.labels
                data.totals = res.data.totals
                data.incomes = res.data.incomes
                data.outgoes = res.data.outgoes
        })
    } catch (e) {
        console.log(e.message)
    }
}

const table_form = reactive({
    category: null,
    partner: null,
})

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
            table_data.all_total = res.data.all_total
        })
    } catch (e) {
        console.log(e.message)
    }
}

</script>

<template>
    <Head title="チャート" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:p-8 px-0 py-8">
                    <form @submit.prevent="getData">
                        <div class="flex items-center w-fit mx-auto mt-8 md:mt-2">
                            <select id="year" name="year" v-model="form.year" class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-8 leading-8 transition-colors duration-200 ease-in-out mr-1">
                                <option :value="null">全期間</option>
                                <option v-for="year in year_list" :value="year['year']" :key="year['year']">{{ year['year'] }}</option>
                            </select>
                            <label for="year" class="leading-7 font-semibold text-sm text-gray-500 mr-5">年</label>

                            <div v-for="year in year_list">
                                <div v-if="year['year'] === form.year">
                                    <select id="month" name="month" v-model="form.month" class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-8 leading-8 transition-colors duration-200 ease-in-out mr-1">
                                        <option :value="null">指定なし</option>
                                        <option v-for="month in year['month']" :value="month['month']" :key="month['month']">{{ month['month'] }}</option>
                                    </select>
                                    <label for="month" class="leading-7 font-semibold text-sm text-gray-500">月</label>
                                </div>
                            </div>

                        </div>
                        <div class="sm:flex items-center w-fit mx-auto mt-8 md:mt-5">
                            <div v-show="form.partner_id === null" class="mr-3">
                                <label for="category_id" class="leading-7 font-semibold text-sm text-gray-500 mr-2">カテゴリ</label>
                                <select id="category_id" name="category_id" v-model="form.category_id" class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-8 leading-8 transition-colors duration-200 ease-in-out mr-1">
                                    <option :value="null">指定なし</option>
                                    <option value="0">全てのカテゴリ</option>
                                    <option v-for="category in categories" :value="category['id']" :key="category['id']">{{ category['name'] }}</option>
                                </select>
                            </div>

                            <div v-show="form.category_id === null" class="sm:mt-0 mt-6">
                                <label for="partner_id" class="leading-7 font-semibold text-sm text-gray-500 mr-2">相手方</label>
                                <select id="partner_id" name="partner_id" v-model="form.partner_id" class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-8 leading-8 transition-colors duration-200 ease-in-out mr-1">
                                    <option :value="null">指定なし</option>
                                    <option value="0">全ての相手方</option>
                                    <option v-for="partner in partners" :value="partner['id']" :key="partner['id']">{{ partner['name'] }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="attention mt-4">
                            <p class="font-md text-xs text-red-500 text-center">※カテゴリまたは相手方を指定する際は、<br class="sm:hidden">他方は「指定なし」を選択してください</p>
                        </div>

                    <button id="chart-button" class="mt-6 mb-8 flex mx-auto text-white bg-indigo-400 border-0 py-2 sm:px-5 px-5 focus:outline-none hover:bg-indigo-500 rounded text-md">グラフを表示する</button>
                    </form>

                    <Chart :data="data" class="mb-20"/>

                    <form @submit.prevent="getTable">
                        <div class="sm:flex items-center w-fit mx-auto mt-8 md:mt-5">
                            <div v-show="table_form.partner === null" class="mr-3">
                                <label for="category" class="leading-7 font-semibold text-sm text-gray-500 mr-2">カテゴリ</label>
                                <select id="category" name="table_category_id" v-model="table_form.category" class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-8 leading-8 transition-colors duration-200 ease-in-out mr-1">
                                    <option :value="null">指定なし</option>
                                    <option v-for="category in categories" :value="category['id']" :key="category['id']">{{ category['name'] }}</option>
                                </select>
                            </div>

                            <div v-show="table_form.category === null" class="sm:mt-0 mt-6">
                                <label for="partner" class="leading-7 font-semibold text-sm text-gray-500 mr-2">相手方</label>
                                <select id="partner" name="partner_id" v-model="table_form.partner" class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-8 leading-8 transition-colors duration-200 ease-in-out mr-1">
                                    <option :value="null">指定なし</option>
                                    <option v-for="partner in partners" :value="partner['id']" :key="partner['id']">{{ partner['name'] }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="attention mt-4">
                            <p class="font-md text-xs text-red-500 text-center">※カテゴリまたは相手方を指定する際は、<br class="sm:hidden">他方は「指定なし」を選択してください</p>
                        </div>

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

                            <div class="tbody">
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
