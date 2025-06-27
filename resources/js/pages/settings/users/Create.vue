<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Create User'"></Breadcrumb>
        <Card title="Create New">
            <div class="flex w-full gap-5 space-y-6">
                <div class="w-1/4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Name </label>
                    <div class="relative z-20 bg-transparent">
                        <Input
                            id="name"
                            type="text"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="name"
                            v-model="formData.name"
                            placeholder="Name"
                        />
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.name">{{ errors.name }}</p>
                </div>

                <div class="w-1/4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Email </label>
                    <div class="relative z-20 bg-transparent">
                        <Input
                            id="email"
                            type="email"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="email"
                            v-model="formData.email"
                            placeholder="Email"
                        />
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.email">{{ errors.email }}</p>
                </div>

                <div class="w-1/3">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Role </label>
                    <div class="relative z-20 bg-transparent">
                        <multiselect
                            v-model="formData.roles"
                            :options="roles"
                            :multiple="true"
                            track-by="id"
                            label="name"
                            :close-on-select="false"
                        ></multiselect>
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.roles">{{ errors.roles }}</p>
                </div>
            </div>
            <div class="flex w-full gap-5 space-y-6">
                <div class="w-1/4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Password </label>
                    <div class="relative z-20 bg-transparent">
                        <Input
                            id="password"
                            type="password"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="password"
                            v-model="formData.password"
                            placeholder="Password"
                        />
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.password">{{ errors.password }}</p>
                </div>

                <div class="w-1/4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Confirm Password </label>
                    <div class="relative z-20 bg-transparent">
                        <Input
                            id="confirm_password"
                            type="password"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="confirm_password"
                            v-model="formData.confirm_password"
                            placeholder="Password"
                        />
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.confirm_password">{{ errors.confirm_password }}</p>
                </div>
            </div>
            <ButtonAction size="sm" variant="primary" @click="submit">Submit</ButtonAction>
        </Card>
    </DefaultLayout>
</template>

<script setup lang="ts">
import Breadcrumb from '@/components/Breadcrumb.vue';
import ButtonAction from '@/components/ButtonAction.vue';
import Card from '@/components/Card.vue';
import { Input } from '@/components/ui/input';
import DefaultLayout from '@/layouts/Default.vue';

import { useSwal } from '@/composables/useSwal';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { useToast } from 'vue-toastification';

import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.min.css';

interface Errors {
    name: string;
    email: string;
    roles: string;
    password: string;
    confirm_password: string;
}

interface Role {
    id: number;
    name: string;
}

interface Props {
    errors: Errors;
    roles: Array<Role>;
}

interface Input {
    name: string;
    email: string;
    roles: Array<number>;
    password: string;
    confirm_password: string;
}

const toast = useToast();
const swal = useSwal();

const formData = reactive<Input>({
    name: '',
    email: '',
    roles: [],
    password: '',
    confirm_password: '',
});

const submit = async (): Promise<void> => {
    const result = await swal.fire({
        title: 'Do you want to save the user?',
        showCancelButton: true,
        confirmButtonText: 'Yes, Save it',
        icon: 'question',
        confirmButtonColor: '#465fff',
    });

    if (result.isConfirmed) {
        router.post(
            '/setting/users',
            {
                name: formData.name,
                email: formData.email,
                roles: formData.roles,
                password: formData.password,
                confirm_password: formData.confirm_password,
            },
            {
                onSuccess: () => {
                    toast.success('User Added Successfully!');
                },
                onError: (error) => {
                    console.log(error);
                    toast.error(`Something went wrong!!`);
                },
            },
        );
    }
};

defineProps<Props>();
</script>
