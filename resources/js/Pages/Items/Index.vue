<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
    items: Object,
    partner: Array,
    subject: Array,
    primary_category: Array,
    secondary_category: Array,
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">仕訳一覧</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8 text-gray-900">

                        <section class="text-gray-600 body-font">
                            <div class="container px-5 pt-0 mb-6 mx-auto">
                                <FlashMessage />
                                <div class="mt-8 w-full mx-auto overflow-auto">
                                <div class="table-auto w-full text-left whitespace-no-wrap">
                                    <div>
                                    <div class="flex">
                                        <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 rounded-tl rounded-bl text-center">日付</div>
                                        <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">相手方</div>
                                        <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">大カテゴリ</div>
                                        <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">対象者</div>
                                        <div class="w-1/5 px-4 py-3 title-font tracking-wider font-medium text-gray-500 text-sm bg-gray-100 text-center">金額</div>
                                    </div>
                                    </div>
                                    <div>
                                    <div v-for="item in items.data" :key="item.id">
                                        <Link :href="route('items.show', { item:item.id })" class="hover:opacity-70 flex">
                                            <div class="w-1/5 px-4 py-3 text-center border-t-2 border-gray-100 text-gray-500">{{ item.date }}</div>
                                            <div class="w-1/5 px-4 py-3 border-t-2 border-gray-100 text-gray-500">{{ item.partner.name }}</div>
                                            <div class="w-1/5 px-4 py-3 border-t-2 border-gray-100 text-gray-500">{{ item.secondary_category.name }}</div>
                                            <div class="w-1/5 px-4 py-3 border-t-2 border-gray-100 text-gray-500"><span v-if="item.subject">{{ item.subject.name }}</span><span v-else>なし</span></div>
                                            <div v-if="item.primary_category.name === '収入'" class="w-1/5 text-right px-4 py-3 text-lg text-blue-500 border-t-2 border-gray-100">￥{{ item.price.toLocaleString() }}</div>
                                            <div v-if="item.primary_category.name === '支出'" class="w-1/5 text-right px-4 py-3 text-lg text-red-500 border-t-2 border-gray-100">￥{{ item.price.toLocaleString() }}</div>
                                        </Link>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <Pagination :links="items.links"></Pagination>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
