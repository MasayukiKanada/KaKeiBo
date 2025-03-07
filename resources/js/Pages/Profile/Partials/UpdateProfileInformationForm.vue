<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const page = usePage();
const user = computed(() => {
    if (page.props && page.props.auth && page.props.auth.user) {
        return page.props.auth.user;
    }
    return null;
});

const form = useForm({
    name: user.value ? user.value.name : '',
    email: user.value ? user.value.email : '',
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">利用者情報</h2>

            <p class="mt-1 text-sm text-gray-600">
                利用者情報の名前とメールアドレスを更新することができます。
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="名前" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="メールアドレス" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="props.mustVerifyEmail && user.value?.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    メールアドレスは認証されておりません。
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        こちらをクリックすると認証用メールを再送します。
                    </Link>
                </p>

                <div
                    v-show="props.status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    登録のメールアドレスに認証用メールを送りました。
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">保存する</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">保存しました。</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
