<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue'
import { getToday } from '@/common'
import Checkbox from '@/Components/Checkbox.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    total_accounts : Object,
    monthly_total_accounts : Object,
});

// const form = reactive({
//     year: null,
//     month: null,
// })

const target = reactive({
    total_account_year: null,
})

const showMonthly = (year) => {
    target.total_account_year = year;
    Inertia.get('/chart', target)
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">収支表</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <!-- <form @submit.prevent="">
                        年： <input type="number" name="year" v-model="form.year">
                        月: <input type="number" name="month" v-model="form.month">
                        <button>検索する</button>
                    </form> -->
                    <div class="mt-8 w-full mx-auto overflow-auto">
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                            <tr>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl text-center">年／月</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">収入</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">支出</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">総計</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="total_account in total_accounts" :key="total_account.id">
                                <td class="px-4 py-3 text-center">{{ total_account.year }}年</td>
                                <td class="text-right px-4 py-3 text-lg text-blue-500">￥{{ total_account.income }}</td>
                                <td class="text-right px-4 py-3 text-lg text-red-500">￥{{ total_account.outcome }}</td>
                                <td v-if="total_account.income - total_account.outcome > 0" class="px-4 py-3 text-right text-lg text-blue-500">￥{{ total_account.income - total_account.outcome }}</td>
                                <td v-if="total_account.income - total_account.outcome < 0" class="px-4 py-3 text-right text-lg text-red-500">￥{{ total_account.income - total_account.outcome }}</td>
                                <td class="px-4 py-3">
                                <!-- <form @submit.prevent="showMonthly">
                                    <input type="hidden" name="year" id="year" v-bind:value="total_account.year" v-on:input="total_account.year = $event.target.value"/> -->
                                    <button @click="showMonthly(total_account.year)" class="text-center text-blue-600 hover:text-blue-400 text-lg">詳細</button>
                                <!-- </form> -->
                                </td>
                            </tr>
                            </tbody>
                            <tbody>
                                <tr v-for="monthly_total_account in monthly_total_accounts">
                                    <td class="px-4 py-3 text-center">{{ monthly_total_account.month }}月</td>
                                    <td class="text-right px-4 py-3 text-lg text-blue-500">￥{{ monthly_total_account.income }}</td>
                                    <td class="text-right px-4 py-3 text-lg text-red-500">￥{{ monthly_total_account.outcome }}</td>
                                    <td v-if="monthly_total_account.income - monthly_total_account.outcome > 0" class="px-4 py-3 text-right text-lg text-blue-500">￥{{ monthly_total_account.income - monthly_total_account.outcome }}</td>
                                    <td v-if="monthly_total_account.income - monthly_total_account.outcome < 0" class="px-4 py-3 text-right text-lg text-red-500">￥{{ monthly_total_account.income - monthly_total_account.outcome }}</td>
                                </tr>
                            </tbody>
                        </table>
                     </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
