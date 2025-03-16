<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { nl2br } from '@/common';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    item: Object
});

const deleteItem = id => {
    Inertia.delete(route('items.destroy', {item:id}), {
        onBefore: () => confirm('本当に削除しますか？')
    });
}

const changeDay = date => {
    return new Date(date).toLocaleDateString("ja-JP", {year: "numeric",month: "2-digit",
    day: "2-digit"}).replace('-', '/');
}

</script>

<template>
    <Head title="仕訳詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-lg text-gray-500 leading-none">仕訳詳細</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-8 mx-auto">

                                <div class="lg:w-2/3 md:w-4/5 mx-auto">
                                <div class="flex flex-wrap -m-2">

                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="date" class="leading-7 text-sm text-gray-500">日付</label>
                                            <div type="date" id="date" name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ changeDay(props.item[0].date) }}
                                            </div>
                                        </div>
                                        </div>

                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="partner" class="leading-7 text-sm text-gray-500">相手先</label>
                                            <div id="partner" name="partner" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{props.item[0].partner.name }}
                                            </div>
                                        </div>
                                        </div>

                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="primary_category" class="leading-7 text-sm text-gray-500">収支区分</label>
                                            <div id="primary_category" name="primary_category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.item[0].primary_category.name }}
                                            </div>
                                        </div>
                                        </div>

                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="secondary_category" class="leading-7 text-sm text-gray-500">大カテゴリ</label>
                                            <div id="secondary_category" name="secondary_category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.item[0].secondary_category.name }}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full" v-if="props.item[0].thirdry_category">
                                        <div class="relative">
                                            <label for="thirdry_category" class="leading-7 text-sm text-gray-500">小カテゴリ</label>
                                            <div id="thirdry_category" name="thirdry_category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.item[0].thirdry_category.name }}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full" v-if="props.item[0].subject">
                                        <div class="relative">
                                            <label for="subject" class="leading-7 text-sm text-gray-500">対象者</label>
                                            <div id="subject" name="subject" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.item[0].subject.name }}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="price" class="leading-7 text-sm text-gray-500">金額</label>
                                            <div type="number" id="price" name="price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.item[0].price }}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full" v-if="props.item[0].memo">
                                        <div class="relative">
                                            <label for="memo" class="leading-7 text-sm text-gray-500">メモ</label>
                                            <div v-html="nl2br(props.item[0].memo)" id="memo" name="memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-500 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        </div>

                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="user" class="leading-7 text-sm text-gray-500">作成者</label>
                                            <div id="user" name="user" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-outt">
                                                {{ props.item[0].user.name }}
                                            </div>
                                        </div>
                                        </div>


                                        <div class="p-2 w-full">
                                            <Link as="button" :href="route('items.edit', { item:props.item[0].id })" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg mt-4">編集する</Link>
                                        </div>

                                        <div class="flex mx-auto text-white bg-red-500 border-0 focus:outline-none hover:bg-red-600 rounded text-lg mt-8">
                                            <button @click="deleteItem(props.item[0].id)" class="py-2 px-8">削除する</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
