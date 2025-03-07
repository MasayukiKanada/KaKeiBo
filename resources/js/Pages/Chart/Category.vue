<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { reactive,onMounted } from 'vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    category_totals: Object,
    monthly_totals: Object,
});

const target = reactive({
    id: null,
})

const $i = 0;

const ChangeMonth = month => {
    let monthObject = new Date(month);
    return monthObject.getMonth() + 1;
}

const separateNum = num => {
    return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
}

</script>

<template>
    <Head title="カテゴリ別" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" v-for="monthly_total in monthly_totals">
                        <section class="text-gray-500 body-font bg-white py-8">
                            <div class="container mx-auto">
                                <FlashMessage />
                                <div class="mt-2 w-full mx-auto overflow-auto">
                                    <h1 class="font-bold text-2xl text-center mb-6">{{ monthly_total.year }}年{{ ChangeMonth(monthly_total.month) }}月</h1>
                                    <div class="table-auto w-full text-left whitespace-no-wrap">
                                        <div class="head flex">
                                            <div class="px-4 py-3 title-font tracking-wider font-medium bg-gray-100 rounded-tl rounded-bl text-center w-1/3">収入
                                            </div>
                                            <div class="px-4 py-3 title-font tracking-wider font-medium bg-gray-100 rounded-tl rounded-bl text-center w-1/3">支出
                                            </div>
                                            <div class="px-4 py-3 title-font tracking-wider font-medium bg-gray-100 rounded-tl rounded-bl text-center w-1/3">合計
                                            </div>
                                        </div>
                                        <div class="body">
                                            <div v-for="monthly_total_budget in monthly_total['budget']" class="row flex">
                                                <div class="text-right px-4 py-3 text-lg text-blue-500 w-1/3">￥{{ separateNum(monthly_total_budget.income) }}</div>
                                                <div class="text-right px-4 py-3 text-lg text-red-500 w-1/3">￥{{ separateNum(monthly_total_budget.outgo) }}</div>
                                                <div v-if="monthly_total_budget.income - monthly_total_budget.outgo > 0" class="text-right px-4 py-3 text-lg text-blue-500 w-1/3">￥{{ separateNum(monthly_total_budget.income - monthly_total_budget.outgo) }}</div>
                                                <div v-if="monthly_total_budget.income - monthly_total_budget.outgo < 0" class="text-right px-4 py-3 text-lg text-red-500 w-1/3">￥{{ separateNum(Math.abs(monthly_total_budget.income - monthly_total_budget.outgo)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <div class="py-4 text-gray-900">

                            <section class="text-gray-600 body-font my-8 py-4 md:px-8 px-4 bg-white">
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
                                            <div v-for="item in category_totals" :key="item.id">
                                                <div v-if="item.year + item.month === monthly_total.year + monthly_total.month">
                                                    <div v-for="data in item.budget" class="flex flex-wrap">
                                                        <div class="w-1/3 px-4 py-3 border-t-2 border-gray-100 font-bold text-gray-500">{{ data.secondary_category.name }}</div>
                                                        <div class="w-1/3 px-4 py-3 border-t-2 border-gray-100 text-gray-500"></div>
                                                        <div v-if="data.secondary_category.primary_category_id === 1" class="w-1/3 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(data.price) }}</div>
                                                        <div v-if="data.secondary_category.primary_category_id === 2" class="w-1/3 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(data.price) }}</div>

                                                        <div class="table-auto w-full text-left whitespace-no-wrap">
                                                        <div v-for="value in item.thirdry_category">
                                                            <div v-if="value.thirdry_category">
                                                                <div v-if="value.thirdry_category['secondary_category_id'] == data.secondary_category.id" class="flex">
                                                                    <div class="w-1/3 px-4 py-3"></div>
                                                                    <div class="w-1/3 px-4 py-3 border-t-2 border-gray-100">{{ value.thirdry_category.name }}</div>
                                                                    <div v-if="data.secondary_category.primary_category_id === 1" class="w-1/3 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(value.price) }}</div>
                                                                    <div v-if="data.secondary_category.primary_category_id === 2" class="w-1/3 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(value.price) }}</div>
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
                            </section>

                        </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>

                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-scrollbar"></div>
                </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

