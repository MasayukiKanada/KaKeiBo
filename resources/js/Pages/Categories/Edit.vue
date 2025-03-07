<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import Category from '../Chart/Category.vue';

const props = defineProps({
    primary_categories: Object,
    current_secondary_category: Object,
    secondary_categories: Object,
    current_thirdry_categories: Object,
    errors: Object,
});

const form = reactive({
    primary_category_id: props.current_secondary_category[0].primary_category_id,
    secondary_category_id: props.current_secondary_category[0].id,
    secondary_category_name: props.current_secondary_category[0].name,
    thirdry_category_id: null,
    thirdry_category_name: null,
})

const updateCategory = id => {
    Inertia.put(route('categories.update', { category: id }), form)
}

const isNotEmpty = obj => {
    return Object.keys(obj).length != 0
}

const deleteCategory = id => {
    console.log(route('categories.destroy', { category: id }));
    Inertia.delete(route('categories.destroy', { category: id }), {
        onBefore: () => confirm('本当に削除しますか？')
    });
}

</script>

<template>
    <Head title="カテゴリ編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-lg text-gray-500 leading-none">カテゴリ編集</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <ValidationErrors :errors="errors" />
                        <section class="text-gray-500 body-font relative">
                            <div class="container px-5 py-8 mx-auto">

                                <form @submit.prevent="updateCategory(form.secondary_category_id)">
                                <div class="lg:w-2/3 md:w-4/5 mx-auto">
                                <div class="flex flex-wrap -m-2">
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="primary_category" class="leading-7 text-sm text-gray-500">収支区分</label>
                                            <select id="primary_category" name="primary_category" v-model="form.primary_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option :value="null" disabled>選択してください</option>
                                                <option v-for="primary_category in primary_categories" :value="primary_category.id" :key="primary_category.id">{{ primary_category.name }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="secondary_category" class="leading-7 text-sm text-gray-500">大カテゴリ名の変更</label>
                                            <input placeholder="変更する大カテゴリ名を入力してください" type="text" id="secondary_category" name="secondary_category" v-model="form.secondary_category_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <input hidden id="secondary_category" name="secondary_category" v-model="form.secondary_category_id">
                                        </div>
                                    </div>

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

                                    <!-- 小カテゴリ名変更の場合 -->
                                    <div class="p-2 w-full" v-if="form.thirdry_category_id !== null">
                                        <div class="relative">
                                            <label for="change_thirdry_category" class="leading-7 text-sm text-gray-500">小カテゴリ名の変更</label>
                                            <input placeholder="変更する小カテゴリ名を入力してください" type="text" id="change_thirdry_category" name="change_thirdry_category" v-model="form.thirdry_category_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <input hidden id="thirdry_category" name="thirdry_category" v-model="form.thirdry_category_id">
                                        </div>
                                    </div>

                                    <!-- 小カテゴリ新規作成の場合 -->
                                    <div class="p-2 w-full" v-if="form.thirdry_category_id === null">
                                        <div class="relative">
                                            <label for="create_thirdry_category" class="leading-7 text-sm text-gray-500">小カテゴリの新規作成</label>
                                            <input placeholder="作成する小カテゴリ名を入力してください" type="text" id="create_thirdry_category" name="create_thirdry_category" v-model="form.thirdry_category_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                    </div>

                                    <div class="p-2 w-full flex mt-10">
                                        <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                                    </div>
                                </div>
                                </div>
                                </form>
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="flex mx-auto text-white bg-red-500 border-0 focus:outline-none hover:bg-red-600 rounded text-lg mt-8">
                                        <button @click="deleteCategory(props.current_secondary_category[0].id)" class="py-2 px-8">削除する</button>
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
