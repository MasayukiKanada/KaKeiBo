<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import { getToday } from '@/common';
import { Inertia } from '@inertiajs/inertia';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import autoComplete from "@tarekraafat/autocomplete.js";
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
    partners: Array,
    subjects: Array,
    primary_categories: Array,
    secondary_categories: Array,
    thirdry_categories: Array,
    user_id: Number,
    errors: Object
});

onMounted(() => {
    form.date = getToday();
    form.user_id = props.user_id;
    form.primary_category_id = 1;
})

const form = reactive({
    primary_category_id: null,
    date: null,
    partner_id: null,
    partner_name: null,
    secondary_category_id: null,
    subject_id: null,
    price: null,
    memo: null,
    thirdry_category_id: null,
    user_id: null,
})

let toCreate = false;

const storeItem = () => {
    toCreate = false;
    Inertia.post(route('items.index'), [form, toCreate])
}

const pushForm = () => {
    toCreate = true;
    Inertia.post(route('items.index'), [form, toCreate])
}

const deleteData = () => {
    //入力取消の場合の処理
    form.primary_category_id = null;
    form.partner_id = null;
    form.partner_name = null;
    form.secondary_category_id = null;
    form.subject_id = null;
    form.price = null;
    form.memo = null;
    form.thirdry_category_id = null;

    //指定位置までのスクロール処理
    const btnToForm = document.querySelector("#create-form");
    btnToForm.scrollIntoView({
        behavior: "smooth"
    });
}

const isNotEmpty = obj => {
    return Object.keys(obj).length != 0
}

window.addEventListener('load', function() {
    //相手方検索のためのAPI
    let partnerData = [];
    const autoCompleteJS = new autoComplete({
        selector: "#partner_search",
        placeHolder: "相手方を検索する",
        resultItem: {
            highlight: true,
        },
        data: {
            src: async (query) => {
                try{
                    const source = await fetch(`/api/searchPartners/?search=${query}`);
                    const data = await source.json();
                    partnerData = data;
                    return data.map((item) => item.name);
                } catch (error) {
                    console.log(error)
                    return [];
                }
            },
            cache: true,
        },
        resultsList: {
            element: (list,data) => {
                if (!data.results.length) {
                    const message = document.createElement("div");
                    message.setAttribute("class", "no_result");
                    message.innerHTML = `<span>該当する結果が見つかりませんでした: "${data.query}"</span>`;
                    list.prepend(message);
                }
            },
            noResults: true,
            id: "partner_list",
        },
        events: {
            input: {
                selection: (event) => {
                const selection = event.detail.selection.value;
                autoCompleteJS.input.value = selection;

                const selectedPartner = partnerData.find(partner => partner.name === selection);
                if (selectedPartner) {
                    form.partner_id = selectedPartner.id;
                }
            }
            }
        },
    })

});

</script>

<template>
    <Head title="仕訳入力" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-lg text-gray-500 leading-none">仕訳入力</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <ValidationErrors :errors="errors" />
                        <section id="create-form" class="text-gray-600 body-font relative">
                            <div class="container px-5 py-8 mx-auto">
                                <FlashMessage />

                                <form @submit.prevent="storeItem">
                                    <div class="lg:w-2/3 md:w-4/5 mx-auto mt-8">
                                        <div class="flex flex-wrap -m-2">

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="date" class="leading-7 text-sm text-gray-500">日付<span class="text-red-500">※</span></label>
                                                    <input type="date" id="date" name="date[]" v-model="form.date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="partner_search" class="leading-7 text-sm text-gray-500">相手方<span class="text-red-500">※</span><span class="text-red-500 text-xs">新規作成の場合は不要</span></label>
                                                    <input class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out hidden md:block" id="partner_search" type="text" name="partner_search[]">
                                                    <select id="partner" name="partner[]" v-model="form.partner_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out hidden md:block" v-if="form.partner_id !== null">
                                                        <option :value="null">選択してください／空白にする</option>
                                                        <option v-for="partner in partners" :value="partner.id" :key="partner.id">{{ partner.name }}</option>
                                                    </select>
                                                    <select id="partner" name="partner[]" v-model="form.partner_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out block md:hidden">
                                                        <option :value="null">選択してください／空白にする</option>
                                                        <option v-for="partner in partners" :value="partner.id" :key="partner.id">{{ partner.name }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full" v-if="form.partner_id === null">
                                                <div class="relative">
                                                    <label for="partner_name" class="leading-7 text-sm text-gray-500">新規相手方</label>
                                                    <input id="partner_name" name="partner_name[]" v-model="form.partner_name" placeholder="追加する相手方を入力してください" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="primary_category1" class="leading-7 text-sm text-gray-500">収支区分<span class="text-red-500">※</span></label>
                                                    <div class="multi_choice">
                                                        <input type="radio" id="primary_category1" name="primary_category1[]" :value="1" v-model="form.primary_category_id">
                                                        <label for="primary_category1">収入</label>
                                                        <input type="radio" id="primary_category2" name="primary_category2[]" :value="2" v-model="form.primary_category_id">
                                                        <label class="red" for="primary_category2">支出</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- form.primary.categoryの値によって条件分岐 -->
                                            <div v-for="primary_category in primary_categories">
                                                <div class="p-2 w-full" v-if="primary_category.id === form.primary_category_id">
                                                    <div class="relative">
                                                        <label for="secondary_category" class="leading-7 text-sm text-gray-500">大カテゴリ<span class="text-red-500">※</span></label>
                                                        <select id="secondary_category" name="secondary_category[]" v-model="form.secondary_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
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
                                                            <select id="thirdry_category" name="thirdry_category[]" v-model="form.thirdry_category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
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
                                                    <select id="subject" name="subject[]" v-model="form.subject_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <option :value="null">選択してください</option>
                                                        <option v-for="subject in subjects" :value="subject.id" :key="subject.id">{{ subject.name }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="price" class="leading-7 text-sm text-gray-500">金額<span class="text-red-500">※</span></label>
                                                    <input type="number" placeholder="金額を入力してください" id="price" name="price[]" v-model="form.price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="memo" class="leading-7 text-sm text-gray-500">メモ</label>
                                                    <textarea id="memo" name="memo[]" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-500 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                                </div>
                                            </div>

                                            <input hidden id="user" name="user" v-model="form.user_id">


                                            <div class="p-2 w-full flex mt-10">
                                                <button type="button" @click="pushForm(form)" as="button" class="flex mx-auto text-white bg-orange-500 border-0 py-2 sm:px-8 px-5 focus:outline-none hover:bg-orange-600 rounded text-lg">連続登録</button>
                                                <button type="button" @click="deleteData" as="button" class="flex mx-auto text-white bg-green-500 border-0 py-2 sm:px-8 px-5 focus:outline-none hover:bg-green-600 rounded text-lg">入力の取消</button>
                                            </div>

                                            <div class="p-2 w-full flex mt-10">
                                                <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 sm:px-8 px-5 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
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
