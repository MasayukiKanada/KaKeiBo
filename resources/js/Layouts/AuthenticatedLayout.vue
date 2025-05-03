<script setup>
import { onMounted, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ApplicationLogoS from '@/Components/ApplicationLogoS.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, Head } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

onMounted(() => {
    const btn_cat = window.document.querySelectorAll('.btn_cat');
    if(route().current('chart.category')) {
        btn_cat.forEach( el => {
            el.classList.add('nav_btn', 'active');
        })
    }

    const btn_item_add = window.document.querySelectorAll('.btn_item_add');
    if(route().current('items.create')) {
        btn_item_add.forEach( el => {
            el.classList.add('nav_btn', 'active');
        })
    }

    const btn_daily = window.document.querySelectorAll('.btn_daily');
    if(route().current('chart.daily')) {
        btn_daily.forEach( el => {
            el.classList.add('nav_btn', 'active');
        })
    }

    const btn_chart = window.document.querySelectorAll('.btn_chart');
    if(route().current('chart.index')) {
        btn_chart.forEach( el => {
            el.classList.add('nav_btn', 'active');
        })
    }

    const btn_cat_add = window.document.querySelectorAll('.btn_cat_add');
    if(route().current('categories.create')) {
        btn_cat_add.forEach( el => {
            el.classList.add('nav_btn', 'active');
        })
    }

    const btn_cat_index = window.document.querySelectorAll('.btn_cat_index');
    if(route().current('categories.index')) {
        btn_cat_index.forEach( el => {
            el.classList.add('nav_btn', 'active');
        })
    }

    const btn_item_index = window.document.querySelectorAll('.btn_item_index');
    if(route().current('items.index')) {
        btn_item_index.forEach( el => {
            el.classList.add('nav_btn', 'active');
        })
    }

})

</script>

<template>
<Head>
    <link rel="icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
</Head>

    <div>
        <div class="min-h-screen bg-gray-100">
            <!-- Logo -->
             <div id="site_header" >
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div id="logo" class="shrink-0 sm:flex items-center hidden">
                        <Link :href="route('chart.daily')" class="active:opacity-60">
                            <ApplicationLogo
                                class="logo block fill-current text-gray-800 ml-12"
                            />
                        </Link>
                    </div>
                </div>
             </div>
            <nav class="bg-white border-b border-gray-100">

                <div id="sp_header" class="sm:hidden block px-4">
                    <div class="flex justify-between h-16">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center sm:hidden">
                            <Link :href="route('chart.daily')" class="active:opacity-60">
                                <ApplicationLogo
                                    class="block w-36 fill-current text-gray-800"
                                />
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 sm:block hidden">
                    <div class="flex justify-between h-16">
                        <div class="flex">

                            <!-- Navigation Links -->
                            <div class="hidden space-x-3 md:space-x-6 sm:-my-px sm:ml-3 md:ml-10 sm:flex">
                                <Link as="button" id="btn_daily" :href="route('chart.daily')" :active="route().current('chart.daily')" class="btn_daily w-16 py-2 active:opacity-60">
                                    <img class="px-4" src="/images/icon/daily.png" alt="日別">
                                    <p class="nav_text text-gray-500 font-medium">日別</p>
                                </Link>
                                <Link as="button" id="btn_cat" :href="route('chart.category')" :active="route().current('chart.category')" class="btn_cat w-16 active:opacity-60">
                                    <img class="px-4" src="/images/icon/category.png" alt="カテゴリ別">
                                    <p class="nav_text text-gray-500 font-medium">カテゴリ別</p>
                                </Link>
                                <Link as="button" id="btn_chart" :href="route('chart.index')" :active="route().current('chart.index')" class="btn_chart w-16 py-2 active:opacity-60">
                                    <img class="px-4" src="/images/icon/chart.png" alt="チャート">
                                    <p class="nav_text text-gray-500 font-medium">チャート</p>
                                </Link>
                                <Link as="button" :href="route('items.index')" :active="route().current('items.index')" class="btn_item_index w-16 py-2 active:opacity-60">
                                    <img class="px-4" src="/images/icon/index.png" alt="仕訳一覧">
                                    <p class="nav_text text-gray-500 font-medium">仕訳一覧</p>
                                </Link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 mr-1 md:mr-5">
                                <Link as="button" :href="route('items.create')" :active="route().current('items.create')" class="btn_item_add w-16 py-2 active:opacity-60">
                                    <img class="px-4" src="/images/icon/create.png" alt="仕訳入力">
                                    <p class="nav_text text-gray-500 font-medium">仕訳入力</p>
                                </Link>
                            </div>
                            <div class="ml-3 mr-1 md:mr-3">
                                <Link as="button" :href="route('categories.index')" :active="route().current('categories.index')" class="btn_cat_index w-16 py-2 active:opacity-60">
                                    <img class="px-4" src="/images/icon/categories.png" alt="カテゴリ管理">
                                    <p class="nav_text text-gray-500 font-medium">カテゴリ管理</p>
                                </Link>
                            </div>
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 nav_user"
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
                                        <DropdownLink :href="route('profile.edit')" class="nav_user flex items-center"><img class="w-8 mr-2" src="/images/icon/profile.png" alt="プロフィール">プロフィール </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button" class="nav_user flex items-center text-red-500">
                                            <img class="w-8 mr-2" src="/images/icon/logout.png" alt="ログアウト">ログアウト
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
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
            <main class="pb-16">
                <slot />
            </main>

            <!-- Responsive Navigation Links-->
            <div class="sp_nav sm:hidden fixed bottom-0 bg-white w-full">
                <div class="pt-2 pb-3 flex items-center justify-around h-20">
                    <div :class="{ block: !showingNavigationDropdown, hidden: showingNavigationDropdown }"
                    class="sm:hidden">
                        <Link as="button" :href="route('categories.create')" class="btn_cat_add w-20 px-2 py-2 active:opacity-60" v-if="route().current('categories.index')">
                                <img class="px-2" src="/images/icon/add-folder.png" alt="カテゴリ作成">
                                <p class="nav_text text-gray-500 font-medium">カテゴリ作成</p>
                        </Link>
                        <Link as="button" :href="route('categories.create')" class="btn_cat_add w-20 px-2 py-2 active:opacity-60" v-else-if="route().current('categories.edit')">
                                <img class="px-2" src="/images/icon/add-folder.png" alt="カテゴリ作成">
                                <p class="nav_text text-gray-500 font-medium">カテゴリ作成</p>
                        </Link>
                        <Link as="button" :href="route('categories.create')" class="btn_cat_add w-20 px-2 py-2 active:opacity-60" v-else-if="route().current('categories.create')">
                                <img class="px-2" src="/images/icon/add-folder.png" alt="カテゴリ作成">
                                <p class="nav_text text-gray-500 font-medium">カテゴリ作成</p>
                        </Link>
                        <Link as="button" id="btn_item_add" :href="route('items.create')" :active="route().current('items.create')" class="btn_item_add w-20 px-2 py-2 active:opacity-60" v-else>
                            <img class="px-2" src="/images/icon/create.png" alt="仕訳入力">
                            <p class="nav_text text-gray-500 font-medium">仕訳入力</p>
                        </Link>
                        <Link as="button" id="btn_daily" :href="route('chart.daily')" :active="route().current('chart.daily')" class="btn_daily w-20 px-2 py-2 active:opacity-60">
                            <img class="px-2" src="/images/icon/daily.png" alt="日別">
                            <p class="nav_text text-gray-500 font-medium">日別</p>
                        </Link>
                        <Link as="button" id="btn_cat" :href="route('chart.category')" :active="route().current('chart.category')" class="btn_cat w-20 px-2 active:opacity-60">
                            <img class="px-2" src="/images/icon/category.png" alt="カテゴリ別">
                            <p class="nav_text text-gray-500 font-medium">カテゴリ別</p>
                        </Link>
                        <Link as="button" id="btn_chart" :href="route('chart.index')" :active="route().current('chart.index')" class="btn_chart w-20 px-2 py-2 active:opacity-60">
                            <img class="px-2" src="/images/icon/chart.png" alt="チャート">
                            <p class="nav_text text-gray-500 font-medium">チャート</p>
                        </Link>
                    </div>
                    <!-- Hamburger -->
                    <div class="mr-1 flex items-center sm:hidden">
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

                    <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('items.index')" :active="route().current('items.index')" class="flex items-center text-sm">
                            <img class="w-10 mr-2" src="/images/icon/index.png" alt="仕訳一覧">仕訳一覧
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('categories.index')" :active="route().current('categories.index')" class="flex items-center text-sm">
                            <img class="w-10 mr-2" src="/images/icon/categories.png" alt="カテゴリ管理">カテゴリ管理
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4 flex items-center">
                            <img class="w-10 mr-2" src="/images/icon/user.png" alt="ユーザー">
                            <div>
                                <div class="font-medium text-gray-800 text-sm">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')" class="flex items-center text-sm"><img class="w-10 mr-2" src="/images/icon/profile.png" alt="プロフィール">プロフィール </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button" class="flex items-center text-red-500 text-sm">
                                <img class="w-10 mr-2" src="/images/icon/logout.png" alt="ログアウト">ログアウト
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
