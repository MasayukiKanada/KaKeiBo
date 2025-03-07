<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="ダッシュボード" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="pt-6 px-6 text-gray-600 font-semibold">{{ $page.props.auth.user.name }}様</div>
                    <div class="p-6 text-gray-600">ログインしました。<br>ようこそ！</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
