<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    total_budgets : Object,
    monthly_total_budgets : Object,
});

const separateNum = num => {
    return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
}

window.addEventListener('load', function() {
    const buttons = document.querySelectorAll('.accordion_button');

    buttons.forEach((button) => {
    button.addEventListener('click', (e) => {
        const body = e.currentTarget.nextElementSibling;
        const thead = body.children[0];
        const theadHeight = thead.offsetHeight;
        const tbody = body.children[1];
        const tbodyHeight = tbody.offsetHeight;
        const menu = e.currentTarget.parentNode;
        menu.classList.toggle('open');

        //条件分岐で開閉を切り替える
        if(menu.classList.contains('open')) {
        body.style.height = theadHeight + tbodyHeight + 'px';
        } else {
        body.style.height = 0;
        }
    });
    });

});

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
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 rounded-tl rounded-bl text-center">年／月</div>
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">収入</div>
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">支出</div>
                                    <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">合計</div>
                                </div>
                            </div>

                            <div class="tbody">
                                <div v-for="total_budget in total_budgets" :key="total_budget.id">
                                    <div class="table_header flex flex-wrap accordion_button">
                                        <div class="w-1/4 px-4 py-3 text-center border-t-2 border-gray-100 text-gray-500 font-bold">{{ total_budget.year }}年</div>
                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.income) }}</div>
                                        <div class="w-1/4 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.outgo) }}</div>
                                        <div v-if="total_budget.income - total_budget.outgo > 0" class="w-1/4 px-4 py-3 text-right text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(total_budget.income - total_budget.outgo) }}</div>
                                        <div v-if="total_budget.income - total_budget.outgo < 0" class="w-1/4 px-4 py-3 text-right text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(Math.abs(total_budget.income - total_budget.outgo)) }}</div>
                                    </div>

                                    <div class="table_body accordion_body">
                                        <div class="thead">
                                            <div class="flex">
                                                <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 rounded-tl rounded-bl text-center">月</div>
                                                <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">収入</div>
                                                <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">支出</div>
                                                <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">小計</div>
                                            </div>
                                        </div>
                                        <div class="tbody monthly_table sm:overflow-x-auto overflow-x-scroll border-gray-100 bg-gray-100">
                                            <div v-for="monthly_total_budget in monthly_total_budgets">
                                                <div v-if="total_budget.year == monthly_total_budget.year" class="flex">
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
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
