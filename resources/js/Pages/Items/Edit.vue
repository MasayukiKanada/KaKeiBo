<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import ValidationErrors from '@/Components/ValidationErrors.vue';

const props = defineProps({
    item: Object,
    partners: Array,
    subjects: Array,
    primary_categories: Array,
    secondary_categories: Array,
    thirdry_categories: Array,
    user_id: Number,
    errors: Object
});

onMounted(() => {
    form.user_id = props.user_id;
})

const form = reactive({
    id: props.item[0].id,
    primary_category_id: props.item[0].primary_category_id,
    date: props.item[0].date,
    partner_id: props.item[0].partner_id,
    secondary_category_id: props.item[0].secondary_category_id,
    subject_id: props.item[0].subject_id,
    price: props.item[0].price,
    memo: props.item[0].memo,
    thirdry_category_id: props.item[0].thirdry_category_id,
    user_id: props.item[0].user_id,
})

const updateItem = id => {
    Inertia.put(route('items.update', { item: id }), form)
}

const isNotEmpty = obj => {
    return Object.keys(obj).length != 0
}

</script>

<template>
    <Head title="仕訳編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-lg text-gray-500 leading-none">仕訳編集</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <ValidationErrors :errors="errors" />
                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-8 mx-auto">

                                <form @submit.prevent="updateItem(form.id)">
                                    <div class="lg:w-2/3 md:w-4/5 mx-auto">
                                        <div class="flex flex-wrap -m-2">

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="date" class="leading-7 text-sm text-gray-500">日付<span class="text-red-500">※</span></label>
                                                    <input type="date" id="date" name="date" v-model="form.date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="partner" class="leading-7 text-sm text-gray-500">相手先<span class="text-red-500">※</span></label>
                                                    <select id="partner" name="partner" v-model="form.partner_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <option v-for="partner in partners" :value="partner.id" :key="partner.id">{{ partner.name }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="primary_category" class="leading-7 text-sm text-gray-500">収支区分<span class="text-red-500">※</span></label>
                                                    <select id="primary_category" name="primary_category" v-model="form.primary_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <option v-for="primary_category in primary_categories" :value="primary_category.id" :key="primary_category.id">{{ primary_category.name }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- form.primary.categoryの値によって条件分岐 -->
                                            <div v-for="primary_category in primary_categories">
                                                <div class="p-2 w-full" v-if="primary_category.id === form.primary_category_id">
                                                    <div class="relative">
                                                        <label for="secondary_category" class="leading-7 text-sm text-gray-500">大カテゴリ<span class="text-red-500">※</span></label>
                                                        <select id="secondary_category" name="secondary_category" v-model="form.secondary_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                            <option :value="null">選択してください</option>
                                                            <option v-for="secondary_category in  primary_category.secondary_category" :value="secondary_category.id" :key="secondary_category.id">{{ secondary_category.name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- form.secondary_categoryの値によって条件分岐 -->
                                            <div v-for="secondary_category in secondary_categories">
                                                <div v-if="isNotEmpty(secondary_category.thirdry_category)">
                                                    <div class="p-2 w-full" v-if="secondary_category.id === form.secondary_category_id">
                                                        <div class="relative">
                                                            <label for="thirdry_category" class="leading-7 text-sm text-gray-500">小カテゴリ</label>
                                                            <select id="thirdry_category" name="thirdry_category" v-model="form.thirdry_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                                <option :value="null">選択してください／空白にする</option>
                                                                <option v-for="thirdry_category in secondary_category.thirdry_category" :value="thirdry_category.id" :key="thirdry_category.id">{{ thirdry_category.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="subject" class="leading-7 text-sm text-gray-500">対象者</label>
                                                    <select id="subject" name="subject" v-model="form.subject_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <option v-for="subject in subjects" :value="subject.id" :key="subject.id">{{ subject.name }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="price" class="leading-7 text-sm text-gray-500">金額<span class="text-red-500">※</span></label>
                                                    <input type="number" id="price" name="price" v-model="form.price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="memo" class="leading-7 text-sm text-gray-500">メモ</label>
                                                    <textarea id="memo" name="memo" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-500 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                                </div>
                                            </div>

                                            <input hidden id="user" name="user" v-model="form.user_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-outt">


                                            <div class="p-2 w-full">
                                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
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
