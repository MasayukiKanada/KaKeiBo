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

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">項目編集</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <ValidationErrors :errors="errors" />
                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-24 mx-auto">

                                <form @submit.prevent="updateItem(form.id)">
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <div class="flex flex-wrap -m-2">

                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                            <input type="date" id="date" name="date" v-model="form.date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        </div>

                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="partner" class="leading-7 text-sm text-gray-600">相手先</label>
                                            <select id="partner" name="partner" v-model="form.partner_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="partner in partners" :value="partner.id" :key="partner.id">{{ partner.name }}</option>
                                            </select>
                                        </div>
                                        </div>

                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="primary_category" class="leading-7 text-sm text-gray-600">収支</label>
                                            <select id="primary_category" name="primary_category" v-model="form.primary_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="primary_category in primary_categories" :value="primary_category.id" :key="primary_category.id">{{ primary_category.name }}</option>
                                            </select>
                                        </div>
                                        </div>

                                        <!-- form.primary.categoryの値によって条件分岐 -->
                                        <div class="p-2 w-full" v-if="form.primary_category_id === 1">
                                        <div class="relative">
                                            <label for="secondary_category" class="leading-7 text-sm text-gray-600">大カテゴリ</label>
                                            <select id="secondary_category" name="secondary_category" v-model="form.secondary_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="secondary_category in primary_categories[0].secondary_category" :value="secondary_category.id" :key="secondary_category.id">{{ secondary_category.name }}</option>
                                            </select>
                                        </div>
                                        </div>

                                        <div class="p-2 w-full" v-if="form.primary_category_id === 2">
                                        <div class="relative">
                                            <label for="secondary_category" class="leading-7 text-sm text-gray-600">大カテゴリ</label>
                                            <select id="secondary_category" name="secondary_category" v-model="form.secondary_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="secondary_category in primary_categories[1].secondary_category" :value="secondary_category.id" :key="secondary_category.id">{{ secondary_category.name }}</option>
                                            </select>
                                        </div>
                                        </div>

                                        <!-- form.secondary.categoryの値によって条件分岐 -->
                                        <div class="p-2 w-full" v-if="form.secondary_category_id === 6">
                                        <div class="relative">
                                            <label for="thirdry_category" class="leading-7 text-sm text-gray-600">小カテゴリ</label>
                                            <select id="thirdry_category" name="thirdry_category" v-model="form.thirdry_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="thirdry_category in secondary_categories[5].thirdry_category" :value="thirdry_category.id" :key="thirdry_category.id">{{ thirdry_category.name }}</option>
                                            </select>
                                        </div>
                                        </div>

                                        <div class="p-2 w-full" v-if="form.secondary_category_id === 8">
                                        <div class="relative">
                                            <label for="thirdry_category" class="leading-7 text-sm text-gray-600">小カテゴリ</label>
                                            <select id="thirdry_category" name="thirdry_category" v-model="form.thirdry_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="thirdry_category in secondary_categories[7].thirdry_category" :value="thirdry_category.id" :key="thirdry_category.id">{{ thirdry_category.name }}</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full" v-if="form.secondary_category_id === 9">
                                        <div class="relative">
                                            <label for="thirdry_category" class="leading-7 text-sm text-gray-600">小カテゴリ</label>
                                            <select id="thirdry_category" name="thirdry_category" v-model="form.thirdry_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="thirdry_category in secondary_categories[8].thirdry_category" :value="thirdry_category.id" :key="thirdry_category.id">{{ thirdry_category.name }}</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full" v-if="form.secondary_category_id === 14">
                                        <div class="relative">
                                            <label for="thirdry_category" class="leading-7 text-sm text-gray-600">小カテゴリ</label>
                                            <select id="thirdry_category" name="thirdry_category" v-model="form.thirdry_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="thirdry_category in secondary_categories[13].thirdry_category" :value="thirdry_category.id" :key="thirdry_category.id">{{ thirdry_category.name }}</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full" v-if="form.secondary_category_id === 17">
                                        <div class="relative">
                                            <label for="thirdry_category" class="leading-7 text-sm text-gray-600">小カテゴリ</label>
                                            <select id="thirdry_category" name="thirdry_category" v-model="form.thirdry_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="thirdry_category in secondary_categories[16].thirdry_category" :value="thirdry_category.id" :key="thirdry_category.id">{{ thirdry_category.name }}</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full" v-if="form.secondary_category_id === 18">
                                        <div class="relative">
                                            <label for="thirdry_category" class="leading-7 text-sm text-gray-600">小カテゴリ</label>
                                            <select id="thirdry_category" name="thirdry_category" v-model="form.thirdry_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="thirdry_category in secondary_categories[17].thirdry_category" :value="thirdry_category.id" :key="thirdry_category.id">{{ thirdry_category.name }}</option>
                                            </select>
                                        </div>
                                        </div>

                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="subject" class="leading-7 text-sm text-gray-600">対象者</label>
                                            <select id="subject" name="subject" v-model="form.subject_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="subject in subjects" :value="subject.id" :key="subject.id">{{ subject.name }}</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="price" class="leading-7 text-sm text-gray-600">金額</label>
                                            <input type="number" id="price" name="price" v-model="form.price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        </div>
                                        <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                            <textarea id="memo" name="memo" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                        </div>
                                        </div>

                                        <input hidden id="user" name="user" v-model="form.user_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-outt">


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
