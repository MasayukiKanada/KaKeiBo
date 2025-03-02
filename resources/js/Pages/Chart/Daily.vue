<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { forEach } from 'lodash';

const props = defineProps({
    items: Object,
    items_formated: Object,
    items_date: Object,
    monthly_totals: Object,
    total_budgets : Object,
    monthly_total_budgets : Object,
    // year: Number,
    // month: Number,
    date_list: Object,
});

const $i = 0;

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">日別</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" v-for="monthly_total in monthly_totals">
                        <section class="text-gray-500 body-font">
                            <div class="container mx-auto">
                                <FlashMessage />
                                <div class="mt-8 w-full mx-auto overflow-auto">
                                    <h1 class="font-bold text-2xl text-center mb-6">{{ monthly_total.year }}年{{ monthly_total.month }}月</h1>
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
                                                <div class="text-right px-4 py-3 text-lg text-blue-500 w-1/3">￥{{ monthly_total_budget.income }}</div>
                                                <div class="text-right px-4 py-3 text-lg text-red-500 w-1/3">￥{{ monthly_total_budget.outgo }}</div>
                                                <div v-if="monthly_total_budget.income - monthly_total_budget.outgo > 0" class="text-right px-4 py-3 text-lg text-blue-500 w-1/3">￥{{ monthly_total_budget.income - monthly_total_budget.outgo }}</div>
                                                <div v-if="monthly_total_budget.income - monthly_total_budget.outgo < 0" class="text-right px-4 py-3 text-lg text-red-500 w-1/3">￥{{ Math.abs(monthly_total_budget.income - monthly_total_budget.outgo) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <div class="p-6 text-gray-900">

                            <section class="text-gray-600 body-font">
                                <div class="container px-5 py-4 mx-auto">
                                    <div class="mt-8 w-full mx-auto overflow-auto">
                                    <div class="table-auto w-full text-left whitespace-no-wrap">
                                        <div>
                                            <div class="flex">
                                                <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl text-center">日付</div>
                                                <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">相手方</div>
                                                <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">主品目</div>
                                                <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">対象者</div>
                                                <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">金額</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div v-for="item in items_formated" :key="item.id">
                                                <div v-if="item.year + item.month === monthly_total.year + monthly_total.month">
                                                    <div v-for="data in item.items['data']">
                                                        <Link :href="route('items.show', { item:data.id })" class="hover:opacity-70 flex">
                                                            <div class="w-1/5 px-4 py-3 text-center border-t-2 border-gray-100">{{ data.date }}</div>
                                                            <div class="w-1/5 px-4 py-3 border-t-2 border-gray-100">{{ data.partner.name }}</div>
                                                            <div class="w-1/5 px-4 py-3 border-t-2 border-gray-100">{{ data.secondary_category.name }}</div>
                                                            <div class="w-1/5 px-4 py-3 border-t-2 border-gray-100"><span v-if="data.subject">{{ data.subject.name }}</span><span v-else>なし</span></div>
                                                            <div v-if="data.primary_category.name === '収入'" class="w-1/5 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ data.price.toLocaleString() }}</div>
                                                            <div v-if="data.primary_category.name === '支出'" class="w-1/5 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ data.price.toLocaleString() }}</div>
                                                        </Link>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <Pagination :links="items.links"></Pagination>
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

