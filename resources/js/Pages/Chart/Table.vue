<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue'
import { getToday } from '@/common'
import Checkbox from '@/Components/Checkbox.vue';
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

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">収支表</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <div class="mt-8 w-full mx-auto overflow-auto">
                        <div class="table-auto w-full text-left whitespace-no-wrap">
                            <div class="thead">
                                <div class="flex">
                                    <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl text-center">年</div>
                                    <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">収入</div>
                                    <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">支出</div>
                                    <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">合計</div>
                                    <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center"></div>
                                </div>
                            </div>

                            <div class="tbody">
                                <div v-for="total_budget in total_budgets" :key="total_budget.id" class="flex flex-wrap">
                                    <div class="w-1/5 px-4 py-3 text-center border-t-2 border-gray-100">{{ total_budget.year }}年</div>
                                    <div class="w-1/5 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ total_budget.income }}</div>
                                    <div class="w-1/5 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ total_budget.outgo }}</div>
                                    <div v-if="total_budget.income - total_budget.outgo > 0" class="w-1/5 px-4 py-3 text-right text-lg text-blue-500 border-t-2 border-gray-100">￥{{ total_budget.income - total_budget.outgo }}</div>
                                    <div v-if="total_budget.income - total_budget.outgo < 0" class="w-1/5 px-4 py-3 text-right text-lg text-red-500 border-t-2 border-gray-100">￥{{ Math.abs(total_budget.income - total_budget.outgo) }}</div>
                                    <div class="w-1/5 px-4 py-3 border-t-2 border-gray-100">
                                        <button @click="showMonthly(total_budget.year)" v-if="total_budget.year != props.year" class="text-center text-blue-600 hover:text-blue-400 text-md border-2 border-blue-500 px-2 rounded-md">内訳</button>
                                    </div>

                                    <div v-if="isNotEmpty(monthly_total_budgets)" class="table-auto w-full text-left whitespace-no-wrap">
                                        <div v-if="total_budget.year === Number(props.year)">
                                            <div class="thead">
                                                <div class="flex">
                                                    <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm rounded-tl rounded-bl text-center"></div>
                                                    <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl text-center">月</div>
                                                    <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">収入</div>
                                                    <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">支出</div>
                                                    <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">小計</div>
                                                </div>
                                            </div>
                                            <div class="tbody">
                                                <div v-for="monthly_total_budget in monthly_total_budgets" class="flex">
                                                    <div class="w-1/5 px-4 py-3 text-center"></div>
                                                    <div class="w-1/5 px-4 py-3 text-center border-t-2 border-gray-100">{{ monthly_total_budget.month }}月</div>
                                                    <div class="w-1/5 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ monthly_total_budget.income }}</div>
                                                    <div class="w-1/5 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ monthly_total_budget.outgo }}</div>
                                                    <div v-if="monthly_total_budget.income - monthly_total_budget.outgo > 0" class="w-1/5 px-4 py-3 text-right text-lg text-blue-500 border-t-2 border-gray-100">￥{{ monthly_total_budget.income - monthly_total_budget.outgo }}</div>
                                                    <div v-if="monthly_total_budget.income - monthly_total_budget.outgo < 0" class="w-1/5 px-4 py-3 text-right text-lg text-red-500 border-t-2 border-gray-100">￥{{ Math.abs(monthly_total_budget.income - monthly_total_budget.outgo) }}</div>
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
