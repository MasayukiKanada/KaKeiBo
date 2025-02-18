<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import { getToday } from '@/common';

const props = defineProps({
    partners: Array,
    subjects: Array,
    primary_categories: Array,
    secondary_categories: Array,
});

onMounted(() => {
    form.date = getToday();
})

const form = reactive({
    primary_category: null,
    date: null,
    partner: null,
    secondary_category: null,
    subject: null,
    price: null,
    memo: null,
})

const storeItem = () => {
 Inertia.post('/items', form)
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">項目作成</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-24 mx-auto">

                                <form @submit.prevent="storeItem">
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <div class="flex flex-wrap -m-2">
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="primary_category" class="leading-7 text-sm text-gray-600">収支</label>
                                            <select id="primary_category" name="primary_category" v-model="form.primary_category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="primary_category in primary_categories" v-bind:value="primary_category.id">{{ primary_category.name }}</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                            <input type="date" id="date" name="date" v-model="form.date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="partner" class="leading-7 text-sm text-gray-600">相手先</label>
                                            <select id="partner" name="partner" v-model="form.partner" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="partner in partners" v-bind:value="partner.id">{{ partner.name }}</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="secondary_category" class="leading-7 text-sm text-gray-600">主品目</label>
                                            <select id="secondary_category" name="secondary_category" v-model="form.secondary_category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="secondary_category in secondary_categories" v-bind:value="secondary_category.id">{{ secondary_category.name }}</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="subject" class="leading-7 text-sm text-gray-600">対象者</label>
                                            <select id="subject" name="subject" v-model="form.subject" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="subject in subjects" v-bind:value="subject.id">{{ subject.name }}</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="price" class="leading-7 text-sm text-gray-600">支払金額</label>
                                            <input type="number" id="price" name="price" v-model="form.price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="memo" class="leading-7 text-sm text-gray-600">備考</label>
                                            <textarea id="memo" name="memo" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Button</button>
                                        </div>
                                    </div>
                                </div>
                                </form>

                            </div>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
