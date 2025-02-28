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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">項目一覧</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-10 mx-auto">
                                <FlashMessage />
                                <div class="mt-8 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                    <tr>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl text-center">日付</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">収支</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">相手方</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">主品目</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">対象者</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">金額</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in items.data" :key="item.id">
                                        <td class="px-4 py-3 text-center">{{ item.date }}</td>
                                        <td class="px-4 py-3">{{ item.primary_category.name }}</td>
                                        <td class="px-4 py-3">{{ item.partner.name }}</td>
                                        <td class="px-4 py-3">{{ item.secondary_category.name }}</td>
                                        <td class="px-4 py-3"><span v-if="item.subject">{{ item.subject.name }}</span><span v-else>なし</span></td>
                                        <td v-if="item.primary_category.name === '収入'" class="text-right px-4 py-3 text-lg text-blue-500">￥{{ item.price.toLocaleString() }}</td>
                                        <td v-if="item.primary_category.name === '支出'" class="text-right px-4 py-3 text-lg text-red-500">￥{{ item.price.toLocaleString() }}</td>
                                        <td class="px-4 py-3"><Link :href="route('items.show', { item:item.id })" class="text-center text-blue-600 hover:text-blue-400">詳細</Link></td>
                                    </tr>
                                    </tbody>
                                </table>
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
