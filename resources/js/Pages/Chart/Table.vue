<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    total_budgets : Object,
    monthly_total_budgets : Object,
    year: String,
});

const target = reactive({
    total_budget_year: null,
})

const $i = 0;


const isNotEmpty = obj => {
    return Object.keys(obj).length != 0
}

const showMonthly = (year) => {
    target.total_budget_year = year;
    Inertia.get('/table', target)
}

const separateNum = num => {
    return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
}

</script>

<template>
    <Head title="収支表" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:p-8 p-0">
                    <div class="mt-8 w-full mx-auto overflow-auto">
                        <div class="table-auto w-full text-left whitespace-no-wrap">
                            <div class="thead">
                                <div class="flex">
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 rounded-tl rounded-bl text-center">年</div>
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">収入</div>
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">支出</div>
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">合計</div>
                                </div>
                            </div>

                            <div class="tbody">
                                <div v-for="total_budget in total_budgets" :key="total_budget.id">
                                    <div @click="showMonthly(total_budget.year)" class="table_header flex flex-wrap">
                                        <div class="w-1/4 px-4 py-3 text-center border-t-2 border-gray-100 text-gray-500 font-bold">{{ total_budget.year }}年</div>
                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.income) }}</div>
                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.outgo) }}</div>
                                        <div v-if="total_budget.income - total_budget.outgo > 0" class="w-1/4 px-4 py-3 text-right text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.income - total_budget.outgo) }}</div>
                                        <div v-if="total_budget.income - total_budget.outgo < 0" class="w-1/4 px-4 py-3 text-right text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(Math.abs(total_budget.income - total_budget.outgo)) }}</div>
                                    </div>

                                    <div v-if="isNotEmpty(monthly_total_budgets)" class="table-auto w-full text-left whitespace-no-wrap">
                                        <div v-if="total_budget.year === Number(props.year)">
                                            <div class="thead">
                                                <div class="flex">
                                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 rounded-tl rounded-bl text-center">月</div>
                                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">収入</div>
                                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">支出</div>
                                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">小計</div>
                                                </div>
                                            </div>
                                            <div class="tbody overflow-x-scroll border-b-8 border-gray-100">
                                                <div v-for="monthly_total_budget in monthly_total_budgets" class="flex">
                                                    <div class="w-1/4 px-4 py-3 text-center border-t-2 border-gray-100 text-gray-500 font-semibold">{{ monthly_total_budget.month }}月</div>
                                                    <div class="w-1/4 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(monthly_total_budget.income) }}</div>
                                                    <div class="w-1/4 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(monthly_total_budget.outgo) }}</div>
                                                    <div v-if="monthly_total_budget.income - monthly_total_budget.outgo > 0" class="w-1/4 px-4 py-3 text-right text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(monthly_total_budget.income - monthly_total_budget.outgo) }}</div>
                                                    <div v-if="monthly_total_budget.income - monthly_total_budget.outgo < 0" class="w-1/4 px-4 py-3 text-right text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(Math.abs(monthly_total_budget.income - monthly_total_budget.outgo)) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
