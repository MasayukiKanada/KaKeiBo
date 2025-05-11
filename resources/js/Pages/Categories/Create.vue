<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import ValidationErrors from '@/Components/ValidationErrors.vue';

const props = defineProps({
    primary_categories: Object,
    secondary_categories: Object,
    errors: Object,
});

onMounted(() => {
    form.primary_category_id = 1;
})

const form = reactive({
    primary_category_id: null,
    secondary_category_id: null,
    secondary_category_name: null,
    thirdry_category_name: null,
})

const storeCategory = () => {
    Inertia.post(route('categories.index'), form)
}

const deleteData = () => {
    form.primary_category_id = null;
    form.secondary_category_id = null;
    form.secondary_category_name = null;
    form.thirdry_category_name = null;
}

</script>

<template>
    <Head title="カテゴリ作成" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-lg text-gray-500 leading-none">カテゴリ作成</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <ValidationErrors :errors="errors" />
                        <section class="text-gray-500 body-font relative">
                            <div class="container px-5 py-8 mx-auto">

                                <form @submit.prevent="storeCategory">
                                    <div class="lg:w-2/3 md:w-4/5 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="primary_category" class="leading-7 text-sm text-gray-500">収支区分<span class="text-red-500">※</span></label>
                                                    <div class="multi_choice">
                                                        <input type="radio" id="primary_category1" name="primary_category" :value="1" v-model="form.primary_category_id">
                                                        <label for="primary_category1">収入</label>
                                                        <input type="radio" id="primary_category2" name="primary_category" :value="2" v-model="form.primary_category_id">
                                                        <label class="red" for="primary_category2">支出</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- form.primary.categoryの値によって条件分岐 -->
                                            <div v-for="primary_category in primary_categories">
                                                <div class="p-2 w-full" v-if="primary_category.id === form.primary_category_id">
                                                    <div class="relative">
                                                        <label for="secondary_category" class="leading-7 text-sm text-gray-500">大カテゴリ<span class="text-red-500">※</span><span class="text-red-500 text-xs">新規作成の場合は不要</span></label>
                                                        <select id="secondary_category" name="secondary_category" v-model="form.secondary_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                            <option :value="null">選択してください／空白にする</option>
                                                            <option v-for="secondary_category in primary_category.secondary_category" :value="secondary_category.id" :key="secondary_category.id">{{ secondary_category.name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 大カテゴリ新規作成の場合 -->
                                            <div class="p-2 w-full" v-if="form.secondary_category_id == null">
                                                <div class="relative">
                                                    <label for="secondary_category_name" class="leading-7 text-sm text-gray-500">大カテゴリの新規作成</label>
                                                    <input placeholder="作成する大カテゴリ名を入力してください" type="text" id="secondary_category_name" name="secondary_category_name" v-model="form.secondary_category_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <!-- 小カテゴリ新規作成の場合 -->
                                            <div class="p-2 w-full" v-if="form.secondary_category_id !== null || form.secondary_category_name !== null">
                                                <div class="relative">
                                                    <label for="thirdry_category" class="leading-7 text-sm text-gray-500">小カテゴリの新規作成</label>
                                                    <input placeholder="作成する小カテゴリ名を入力してください" type="text" id="thirdry_category" name="thirdry_category" v-model="form.thirdry_category_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <div class="p-2 w-full flex mt-10">
                                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 sm:px-8 px-5 focus:outline-none hover:bg-indigo-600 rounded text-lg">作成する</button>
                                                <button @click="deleteData" as="button" class="flex mx-auto text-white bg-green-500 border-0 py-2 sm:px-8 px-5 focus:outline-none hover:bg-green-600 rounded text-lg">入力の取消</button>
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
