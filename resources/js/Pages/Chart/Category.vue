<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { reactive,onMounted } from 'vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    page: Number,
    date_newArry: Array,
    category_totals: Object,
    monthly_totals: Object,
});

const ChangeMonth = month => {
    let monthObject = new Date(month);
    return monthObject.getMonth() + 1;
}

const separateNum = num => {
    return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
}

const target = reactive({
    page: props.page,
})

const nextPage = page => {
    target.page = page + 1;
    Inertia.get(route('chart.category'), target);
}

const prevPage = page => {
    target.page = page - 1;
    Inertia.get(route('chart.category'), target);
}

</script>

<template>
    <Head title="カテゴリ別" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg">

                        <div v-for="monthly_total in monthly_totals">
                            <section class="total_table text-gray-500 body-font shadow-sm bg-white py-8">
                            <div class="container mx-auto">
                                <FlashMessage />
                                <div class="mt-2 w-full mx-auto overflow-auto">
                                    <h1 class="font-bold text-2xl text-center mb-6">{{ date_newArry[props.page]['year'] }}年{{ date_newArry[props.page]['month'] }}月</h1>
                                    <div class="table-auto w-full text-left whitespace-no-wrap">
                                        <div class="head flex">
                                            <div class="px-4 py-3 title-font tracking-wider font-medium bg-gray-100 rounded-tl rounded-bl text-center w-1/3">収入
                                            </div>
                                            <div class="px-4 py-3 title-font tracking-wider font-medium bg-gray-100 rounded-tl rounded-bl text-center w-1/3">支出
                                            </div>
                                            <div class="px-4 py-3 title-font tracking-wider font-medium bg-gray-100 rounded-tl rounded-bl text-center w-1/3">合計
                                            </div>
                                        </div>
                                        <div class="body flex">
                                            <div class="text-right px-4 py-3 text-lg text-blue-500 w-1/3">￥{{ separateNum(monthly_total.income) }}</div>
                                            <div class="text-right px-4 py-3 text-lg text-red-500 w-1/3">￥{{ separateNum(monthly_total.outgo) }}</div>
                                            <div v-if="monthly_total.income - monthly_total.outgo > 0" class="text-right px-4 py-3 text-lg text-blue-500 w-1/3">￥{{ separateNum(monthly_total.income - monthly_total.outgo) }}</div>
                                            <div v-if="monthly_total.income - monthly_total.outgo < 0" class="text-right px-4 py-3 text-lg text-red-500 w-1/3">￥{{ separateNum(Math.abs(monthly_total.income - monthly_total.outgo)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="page_nav_btn next" v-if="(props.page + 1) === date_newArry.length">
                                <button disabled class="arrow next disabled" as="button" @click="nextPage(props.page)"></button>
                            </div>
                            <div class="page_nav_btn next" v-else>
                                <button class="arrow next" as="button" @click="nextPage(props.page)"></button>
                            </div>
                            <div class="page_nav_btn prev" v-if="props.page == 0">
                                <button disabled class="arrow prev disabled" as="button" @click="prevPage(props.page)"></button>
                            </div>
                            <div class="page_nav_btn prev" v-else>
                                <button class="arrow prev" as="button" @click="prevPage(props.page)"></button>
                            </div>
                        </section>

                        <div class="py-4 text-gray-900">

                            <section class="text-gray-600 body-font my-8 py-4 md:px-8 px-0 bg-white shadow-sm">
                                <div class="container py-4 mx-auto">
                                    <div class="mt-0 w-full mx-auto overflow-auto">
                                    <div class="table-auto w-full text-left whitespace-no-wrap">
                                        <div>
                                            <div class="flex">
                                                <div class="w-1/3 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl text-center">大カテゴリ</div>
                                                <div class="w-1/3 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">小カテゴリ</div>
                                                <div class="w-1/3 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">金額</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div v-for="budget in category_totals['budget']">
                                                <div class="flex flex-wrap">
                                                    <div class="w-1/3 px-4 py-3 border-t-2 border-gray-100 font-semibold text-gray-500">{{ budget["secondary_category"].name }}</div>
                                                    <div class="w-1/3 px-4 py-3 border-t-2 border-gray-100 text-gray-500"></div>
                                                    <div v-if="budget['secondary_category'].primary_category_id === 1" class="w-1/3 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(budget.price) }}</div>
                                                    <div v-if="budget['secondary_category'].primary_category_id === 2" class="w-1/3 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(budget.price) }}</div>
                                                </div>

                                                    <div class="table-auto w-full text-left whitespace-no-wrap">
                                                    <div v-for="value in category_totals['thirdry_category']">
                                                        <div v-if="value.thirdry_category">
                                                            <div v-if="value.thirdry_category['secondary_category_id'] == budget['secondary_category'].id" class="flex">
                                                                <div class="w-1/3 px-4 py-3"></div>
                                                                <div class="w-1/3 px-4 py-3 border-t-2 border-gray-100">{{ value.thirdry_category.name }}</div>
                                                                <div v-if="budget['secondary_category'].primary_category_id === 1" class="w-1/3 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(value.price) }}</div>
                                                                <div v-if="budget['secondary_category'].primary_category_id === 2" class="w-1/3 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(value.price) }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </section>

                        </div>
                        </div>
                    </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

