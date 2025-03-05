<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
    categories_income: Object,
    categories_outgo: Object,
    secondary_categories: Object,
});

</script>

<template>
    <Head title="カテゴリ管理" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">カテゴリ管理</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <Link as="button" :href="route('categories.create')" class="flex ml-auto mr-6 text-white bg-orange-300 border-0 py-2 px-6 focus:outline-none hover:bg-orange-400 rounded">カテゴリ作成</Link>

                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-2 mx-auto">
                                <FlashMessage />
                                <div class="mt-8 w-full mx-auto overflow-auto">
                                <div class="table-auto w-full text-left whitespace-no-wrap">
                                    <div>
                                    <div class="flex">
                                        <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">収支区分</div>
                                        <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">大カテゴリ</div>
                                        <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">小カテゴリ</div>
                                        <div class="w-1/4 px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center"></div>
                                    </div>
                                    </div>

                                    <div>
                                        <div v-for="primary_category in categories_income" class="flex flex-wrap">
                                            <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100">{{ primary_category.name }}</div>
                                            <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                            <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                            <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                        </div>
                                        <div v-for="secondary_category in categories_income[0].secondary_category">
                                            <div class="flex flex-wrap">
                                                    <div class="w-1/4 px-4 py-3 border-gray-100"></div>
                                                    <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100">{{ secondary_category.name }}</div>
                                                    <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                                    <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                            </div>
                                            <div v-for="thirdry_category in secondary_categories">
                                                <div v-if="thirdry_category.id === secondary_category.id">
                                                    <div v-for="category in thirdry_category.thirdry_category" class="flex">
                                                        <div class="w-1/4 px-4 py-3 border-gray-100"></div>
                                                        <div class="w-1/4 px-4 py-3 border-gray-100"></div>
                                                        <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100">{{ category.name}}</div>
                                                        <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div v-for="primary_category in categories_outgo" class="flex flex-wrap">
                                            <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100">{{ primary_category.name }}</div>
                                            <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                            <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                            <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                        </div>
                                        <div v-for="secondary_category in categories_outgo[0].secondary_category">
                                            <div class="flex flex-wrap">
                                                    <div class="w-1/4 px-4 py-3 border-gray-100"></div>
                                                    <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100">{{ secondary_category.name }}</div>
                                                    <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                                    <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                            </div>
                                            <div v-for="thirdry_category in secondary_categories">
                                                <div v-if="thirdry_category.id === secondary_category.id">
                                                    <div v-for="category in thirdry_category.thirdry_category" class="flex">
                                                        <div class="w-1/4 px-4 py-3 border-gray-100"></div>
                                                        <div class="w-1/4 px-4 py-3 border-gray-100"></div>
                                                        <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100">{{ category.name}}</div>
                                                        <div class="w-1/4 px-4 py-3 border-t-2 border-gray-100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
