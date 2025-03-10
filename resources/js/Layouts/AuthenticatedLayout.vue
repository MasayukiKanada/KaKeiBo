<script setup>
import { onMounted, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ApplicationLogoS from '@/Components/ApplicationLogoS.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

onMounted(() => {
    const btn = window.document.querySelector('#cat_btn');
    if(route().current('categories.index')) {
        btn.classList.add('active');
    }

    const create_btn = window.document.querySelector('#create_btn');
    if(route().current('items.create') || route().current('items.show')
    || route().current('items.edit') || route().current('categories.edit')
    || route().current('categories.create') || route().current('categories.index') ) {
        create_btn.classList.add('hidden');
    }

    const category_btn = window.document.querySelector('#category_btn');
    if(route().current('categories.index') === false) {
        category_btn.classList.add('hidden');
    }
})

const showingNavigationDropdown = ref(false);

</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <!-- Logo -->
             <div id="site_header">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div id="logo" class="shrink-0 sm:flex items-center hidden">
                        <Link :href="route('chart.daily')">
                            <ApplicationLogo
                                class="logo block fill-current text-gray-800 ml-12"
                            />
                        </Link>
                    </div>
                </div>
             </div>
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center sm:hidden">
                                <Link :href="route('chart.daily')">
                                    <ApplicationLogoS
                                        class="block w-12 fill-current text-gray-800"
                                    />
                                </Link>
                            </div>
                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('chart.daily')" :active="route().current('chart.daily')">
                                    日別
                                </NavLink>
                                <NavLink :href="route('chart.category')" :active="route().current('chart.category')">
                                    カテゴリ別
                                </NavLink>
                                <NavLink :href="route('chart.table')" :active="route().current('chart.table')">
                                    収支表
                                </NavLink>
                                <NavLink :href="route('items.index')" :active="route().current('items.index')">
                                    仕訳一覧
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 md:mr-12 mr-3">
                                <Link as="button" :href="route('items.create')" class="flex ml-auto text-white bg-indigo-400 border-0 md:py-1 px-6 focus:outline-none hover:bg-indigo-500 rounded font-semibold">仕訳入力</Link>
                            </div>
                            <div class="ml-3 md:mr-12 mr-3">
                                <Link id="cat_btn" as="button" :href="route('categories.index')" class="flex ml-auto text-white bg-gray-400 border-0 md:py-1 px-6 focus:outline-none hover:bg-gray-500 rounded font-semibold">カテゴリ管理</Link>
                            </div>
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> プロフィール </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            ログアウト
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('chart.daily')" :active="route().current('chart.daily')">
                            日別
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('chart.category')" :active="route().current('chart.category')">
                            カテゴリ別
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('chart.table')" :active="route().current('chart.table')">
                            収支表
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('items.index')" :active="route().current('items.index')">
                            仕訳一覧
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('categories.index')" :active="route().current('categories.index')">
                            カテゴリ管理
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> プロフィール </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                ログアウト
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>

            <!-- Responsive Buttons -->
            <div class="sm:hidden flex fixed bottom-0 sm:items-center sm:ml-6 w-full z-50">
                <div class="w-full">
                    <Link id="create_btn" as="button" :href="route('items.create')" class="block w-full ml-auto text-white bg-indigo-400 border-0 py-1 px-6 focus:outline-none hover:bg-indigo-500 font-semibold">仕訳入力</Link>
                    <Link id="category_btn" as="button" :href="route('categories.create')" class="block w-full ml-auto mr-6 text-white bg-orange-300 border-0 py-2 px-6 focus:outline-none hover:bg-orange-400 rounded font-semibold">カテゴリ作成</Link>
                </div>
            </div>
        </div>
    </div>
</template>
