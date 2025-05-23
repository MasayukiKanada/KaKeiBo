<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    items: Object,
    partner: Array,
    subject: Array,
    primary_category: Array,
    secondary_category: Array,
    sortBy: String,
});

const form = reactive({
    sortBy: props.sortBy,
})

const separateNum = num => {
    return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
}

const changeDay = date => {
    return new Date(date).toLocaleDateString("ja-JP", {year: "numeric",month: "2-digit",
    day: "2-digit"}).replace('-', '/');
}

const selectSort =() => {
    Inertia.get(route('items.index'), form)
}

</script>

<template>
    <Head title="仕訳一覧" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="md:p-8 py-4 px-2 text-gray-900">

                        <section class="text-gray-600 body-font">
                            <div class="container md:px-5 px-0 pt-0 md:mb-6 mb-10 mx-auto">
                                <FlashMessage />
                                <div class="mt-3 w-full mx-auto overflow-auto">
                                    <div class="flex justify-end mb-6">
                                        <form @submit.prevent="selectSort">
                                            <select name="sort" id="sort"  v-model="form.sortBy" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-8 leading-8 transition-colors duration-200 ease-in-out">
                                                <option value="createDesc">登録降順</option>
                                                <option value="createAsc">登録昇順</option>
                                                <option value="dateDesc">日付降順</option>
                                                <option value="dateAsc">日付昇順</option>
                                            </select>
                                            <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-1 sm:px-8 px-5 mt-3 focus:outline-none hover:bg-indigo-600 rounded text-lg">並び替え</button>
                                        </form>
                                    </div>
                                    <div class="table-auto w-full text-left whitespace-no-wrap">
                                        <div>
                                            <div class="flex">
                                                <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 rounded-tl rounded-bl text-center">日付</div>
                                                <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">相手方</div>
                                                <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">大カテゴリ</div>
                                                <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">金額</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div v-for="item in items.data" :key="item.id">
                                                <Link :href="route('items.edit', { item:item.id })" class="hover:opacity-70 flex">
                                                    <div class="w-1/4 px-4 py-3 text-center border-t-2 border-gray-100 text-gray-500">{{ changeDay(item.date) }}</div>
                                                    <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100 text-gray-500">{{ item.partner.name }}</div>
                                                    <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100 text-gray-500">{{ item.secondary_category.name }}</div>
                                                    <div v-if="item.primary_category.id === 1" class="w-1/4 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ separateNum(item.price) }}</div>
                                                    <div v-if="item.primary_category.id === 2" class="w-1/4 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ separateNum(item.price) }}</div>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <Pagination :links="items.links" class="mb-6 md:mb-0"></Pagination>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
