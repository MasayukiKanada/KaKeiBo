<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import { nl2br } from '@/common';

const props = defineProps({
    item: Object
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">項目詳細</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-24 mx-auto">

                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <div class="flex flex-wrap -m-2">
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="primary_category" class="leading-7 text-sm text-gray-600">収支</label>
                                            <div id="primary_category" name="primary_category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.item[0].primary_category.name }}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                            <div type="date" id="date" name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.item[0].date }}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="partner" class="leading-7 text-sm text-gray-600">相手先</label>
                                            <div id="partner" name="partner" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{props.item[0].partner.name }}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="secondary_category" class="leading-7 text-sm text-gray-600">主品目</label>
                                            <div id="secondary_category" name="secondary_category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.item[0].secondary_category.name }}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full" v-if="props.item[0].thirdry_category">
                                        <div class="relative">
                                            <label for="thirdry_category" class="leading-7 text-sm text-gray-600">細目</label>
                                            <div id="thirdry_category" name="thirdry_category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.item[0].thirdry_category.name }}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full" v-if="props.item[0].subject">
                                        <div class="relative">
                                            <label for="subject" class="leading-7 text-sm text-gray-600">対象者</label>
                                            <div id="subject" name="subject" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.item[0].subject.name }}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="price" class="leading-7 text-sm text-gray-600">支払金額</label>
                                            <div type="number" id="price" name="price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ props.item[0].price }}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full" v-if="props.item[0].memo">
                                        <div class="relative">
                                            <label for="memo" class="leading-7 text-sm text-gray-600">備考</label>
                                            <div v-html="nl2br(props.item[0].memo)" id="memo" name="memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        </div>

                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="user" class="leading-7 text-sm text-gray-600">作成者</label>
                                            <div id="user" name="user" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-outt">
                                                {{ props.item[0].user.name }}
                                            </div>
                                        </div>
                                        </div>


                                        <div class="p-2 w-full">
                                        <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">編集する</button>
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
