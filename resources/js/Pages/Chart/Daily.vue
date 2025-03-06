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
    monthly_totals: Object,
});

const $i = 0;

const changeDate = date => {
   let dateObject = new Date(date);
   return dateObject.getDate();
}

const ChangeMonth = month => {
    let monthObject = new Date(month);
    return monthObject.getMonth() + 1;
}

const days = [
    "日曜日",
    "月曜日",
    "火曜日",
    "水曜日",
    "木曜日",
    "金曜日",
    "土曜日",
];

const changeDay = day => {
    let dayObject = new Date(day);
    return days[dayObject.getDay()];
}

</script>

<template>
    <Head title="日別" />

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

                        <div class="py-2 text-gray-900">

                            <section class="text-gray-600 body-font">
                                <div class="py-4 mx-auto">
                                    <div class="mt-0 w-full mx-auto overflow-auto">
                                    <div class="table-auto w-full text-left whitespace-no-wrap">

                                            <div v-for="item in items_formated" :key="item.id">
                                                <div v-if="item.year + item.month === monthly_total.year + monthly_total.month">
                                                    <div v-for="daily_budget in item.daily_budget" class="my-8 py-4 px-8 bg-white">

                                                        <div class="flex flex-wrap">
                                                            <div class="w-3/5 px-4 py-3 text-center text-2xl font-bold border-gray-100 flex items-center">{{ changeDate(daily_budget.date) }}<span class="text-sm block mt-2">日</span><span class="px-2 py-1 bg-gray-300 rounded-md text-white font-normal text-sm ml-6 block">{{ changeDay(daily_budget.date) }}</span></div>
                                                            <div class="w-1/5 text-right px-4 py-3 text-lg text-blue-500 border-gray-100">￥{{ daily_budget.income }}</div>
                                                            <div class="w-1/5 text-right px-4 py-3 text-lg text-red-500 border-gray-100">￥{{ daily_budget.outgo }}</div>
                                                        </div>

                                                        <div class="table-auto w-full text-left whitespace-no-wrap">
                                                            <div class="thead flex">
                                                                <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 rounded-tl rounded-bl text-center"></div>
                                                                <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">相手方</div>
                                                                <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">大カテゴリ</div>
                                                                <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">対象者</div>
                                                                <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">金額</div>
                                                            </div>
                                                        </div>

                                                        <div v-for="data in item.items" class="tbody table-auto w-full text-left whitespace-no-wrap">
                                                            <div v-if="data.date === daily_budget.date">
                                                                <Link :href="route('items.show', { item:data.id })" class="hover:opacity-70 flex">
                                                                    <div class="w-1/5 px-4 py-3 border-t-2 text-gray-500 border-gray-100"></div>
                                                                    <div class="w-1/5 px-4 py-3 border-t-2 text-gray-500 border-gray-100">{{ data.partner.name }}</div>
                                                                    <div class="w-1/5 px-4 py-3 border-t-2 text-gray-500 border-gray-100">{{ data.secondary_category.name }}</div>
                                                                    <div class="w-1/5 px-4 py-3 border-t-2 text-gray-500 border-gray-100"><span v-if="data.subject">{{ data.subject.name }}</span><span v-else>なし</span></div>
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
                                </div>
                                <!-- <Pagination :links="items_formated[0]['items'].links"></Pagination> -->
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

