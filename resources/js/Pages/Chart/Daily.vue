<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { Inertia, useInertia } from '@inertiajs/inertia';

const props = defineProps({
    page: Number,
    date_newArry: Array,
    items: Object,
    items_formated: Object,
    monthly_totals: Object,
});

const changeDate = date => {
   let dateObject = new Date(date);
   return dateObject.getDate();
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

const separateNum = num => {
    return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
}

const target = reactive({
    page: props.page,
})

const nextPage = page => {
    target.page = page + 1;
    Inertia.get(route('chart.daily'), target);
}

const prevPage = page => {
    target.page = page - 1;
    Inertia.get(route('chart.daily'), target);
}

</script>

<template>
    <Head title="日別" />

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
                                            {{ monthly_total }}
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

                        <div class="py-2 text-gray-900">

                            <section class="text-gray-600 body-font">
                                <div class="py-4 mx-auto">
                                    <div class="mt-0 w-full mx-auto overflow-auto">
                                    <div class="table-auto w-full text-left whitespace-no-wrap">

                                        <div v-for="daily_budget in items_formated['daily_budget']" class="my-8 py-4 bg-white md:px-8 px-0 shadow-sm">

                                            <div class="flex">
                                                <div class="w-4/8 px-4 py-3 text-center text-2xl font-bold border-gray-100 flex items-center">{{ changeDate(daily_budget.date) }}<span class="text-sm block mt-2">日</span><span class="px-2 py-1 bg-gray-300 rounded-md text-white font-normal text-sm ml-3 block">{{ changeDay(daily_budget.date) }}</span></div>
                                                <div class="w-2/8 text-right px-4 py-3 text-lg text-blue-500 border-gray-100">￥{{ separateNum(daily_budget.income) }}</div>
                                                <div class="w-2/8 text-right px-4 py-3 text-lg text-red-500 border-gray-100">￥{{ separateNum(daily_budget.outgo) }}</div>
                                            </div>

                                            <div class="table-auto w-full text-left whitespace-no-wrap">
                                                <div class="thead flex">
                                                    <div class="w-1/3 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-left">相手方</div>
                                                    <div class="w-1/3 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-left">大カテゴリ</div>
                                                    <div class="w-1/3 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">金額</div>
                                                </div>
                                            </div>

                                            <div v-for="data in items_formated['items']" class="tbody table-auto w-full text-left whitespace-no-wrap">
                                                <div v-if="data.date === daily_budget.date">
                                                    <Link :href="route('items.show', { item:data.id })" class="hover:opacity-70 flex">
                                                        <div class="w-1/3 px-4 py-3 border-t-2 text-gray-500 border-gray-100">{{ data.partner.name }}</div>
                                                        <div class="w-1/3 px-4 py-3 border-t-2 text-gray-500 border-gray-100">{{ data.secondary_category.name }}</div>
                                                        <div v-if="data.primary_category.name === '収入'" class="w-1/3 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(data.price) }}</div>
                                                        <div v-if="data.primary_category.name === '支出'" class="w-1/3 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(data.price) }}</div>
                                                    </Link>
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
            </div>
        </div>
    </AuthenticatedLayout>
</template>

