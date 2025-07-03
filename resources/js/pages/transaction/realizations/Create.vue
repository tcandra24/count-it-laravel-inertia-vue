<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Create Realization'"></Breadcrumb>
        <Card title="Create New">
            <div class="flex w-full gap-5 space-y-6">
                <div class="w-1/4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Plan </label>
                    <div class="relative z-20 bg-transparent">
                        <select
                            v-model="formData.plan_detail_id"
                            class="dark:bg-dark-900 shadow-theme-xs w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="{
                                'text-gray-800 dark:text-white/90': formData.plan_detail_id,
                                'border-error-300 focus:border-error-300 focus:ring-error-500/10 dark:border-error-700 dark:focus:border-error-800':
                                    errors.plan_detail_id,
                            }"
                        >
                            <option value="" disabled selected>Select Plan</option>
                            <optgroup v-for="(plan, index) of plans" :key="plan.id" :label="`Plan ${index + 1}`">
                                <option v-for="detail of plan.detail" :key="detail.id" :value="detail.id">{{ detail.name }}</option>
                            </optgroup>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"
                                    stroke=""
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </span>
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.plan_detail_id">{{ errors.plan_detail_id }}</p>
                </div>
            </div>
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
                <div class="w-1/6">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Qty </label>
                    <div class="relative z-20 bg-transparent">
                        <Input id="qty" type="number" required autofocus :tabindex="1" autocomplete="qty" v-model="formData.qty" placeholder="Qty" />
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.qty">{{ errors.qty }}</p>
                </div>

                <div class="w-1/6">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Unit </label>
                    <div class="relative z-20 bg-transparent">
                        <select
                            v-model="formData.unit_id"
                            class="dark:bg-dark-900 shadow-theme-xs w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="{
                                'text-gray-800 dark:text-white/90': formData.unit_id,
                                'border-error-300 focus:border-error-300 focus:ring-error-500/10 dark:border-error-700 dark:focus:border-error-800':
                                    errors.unit_id,
                            }"
                        >
                            <option value="" disabled selected>Select Unit</option>
                            <option v-for="unit of units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"
                                    stroke=""
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </span>
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.unit_id">{{ errors.unit_id }}</p>
                </div>

                <div class="w-1/4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Price </label>
                    <div class="relative z-20 bg-transparent">
                        <Input
                            id="price"
                            type="number"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="price"
                            v-model="formData.price"
                            placeholder="Price"
                        />
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.price">{{ errors.price }}</p>
                </div>
            </div>
            <div class="flex w-full gap-5 space-y-6">
                <div class="w-1/2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Note </label>
                    <div class="relative z-20 bg-transparent">
                        <textarea
                            id="note"
                            class="dark:bg-dark-900 shadow-theme-xs w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            v-model="formData.note"
                            :class="{
                                'text-gray-800 dark:text-white/90': formData.note,
                                'border-error-300 focus:border-error-300 focus:ring-error-500/10 dark:border-error-700 dark:focus:border-error-800':
                                    errors.note,
                            }"
                        ></textarea>
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.note">{{ errors.note }}</p>
                </div>
            </div>
            <div class="flex w-full gap-5 space-y-6">
                <div class="w-1/4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Image </label>
                    <div class="relative z-20 bg-transparent">
                        <input
                            type="file"
                            @input="handleImageChange"
                            class="dark:bg-dark-900 shadow-theme-xs w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="{
                                'text-gray-800 dark:text-white/90': formData.image,
                                'border-error-300 focus:border-error-300 focus:ring-error-500/10 dark:border-error-700 dark:focus:border-error-800':
                                    errors.image,
                            }"
                        />
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.image">{{ errors.image }}</p>
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

interface PlanDetail {
    id: number;
    name: string;
    qty: number;
    price: number;
    total: number;
}

interface Plan {
    id: number;
    month: number;
    year: number;
    is_active: number;
    detail: Array<PlanDetail>;
}

interface Unit {
    id: number;
    name: string;
}

interface Errors {
    plan_detail_id: string;
    unit_id: string;
    name: string;
    note: string;
    qty: string;
    price: string;
    image: string;
}

interface Props {
    errors: Errors;
    plans: Array<Plan>;
    units: Array<Unit>;
}

interface Input {
    plan_detail_id: number | null;
    unit_id: number;
    name: string;
    note: string;
    qty: number;
    price: number;
    image: File | null;
}

const toast = useToast();
const swal = useSwal();

const formData = reactive<Input>({
    plan_detail_id: null,
    unit_id: 0,
    name: '',
    note: '',
    qty: 0,
    price: 0,
    image: null,
});

const handleImageChange = (event: Event) => {
    const inputElement = event.target as HTMLInputElement;
    if (inputElement.files && inputElement.files.length > 0) {
        formData.image = inputElement.files[0];
    } else {
        formData.image = null;
    }
};

const submit = async (): Promise<void> => {
    const result = await swal.fire({
        title: 'Do you want to save the realization?',
        showCancelButton: true,
        confirmButtonText: 'Yes, Save it',
        icon: 'question',
        confirmButtonColor: '#465fff',
    });

    if (result.isConfirmed) {
        router.post(
            '/transaction/realizations',
            {
                plan_detail_id: formData.plan_detail_id,
                unit_id: formData.unit_id,
                name: formData.name,
                note: formData.note,
                qty: formData.qty,
                price: formData.price,
                image: formData.image,
            },
            {
                onSuccess: () => {
                    toast.success('Realization Added Successfully!');
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
