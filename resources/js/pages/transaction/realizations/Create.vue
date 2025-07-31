<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Create Realization'"></Breadcrumb>
        <Card title="Create New">
            <div class="flex w-full gap-5 space-y-6">
                <div class="w-1/4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Month </label>
                    <div class="relative z-20 bg-transparent">
                        <select
                            v-model="formData.month"
                            class="dark:bg-dark-900 shadow-theme-xs w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="{
                                'text-gray-800 dark:text-white/90': formData.month,
                                'border-error-300 focus:border-error-300 focus:ring-error-500/10 dark:border-error-700 dark:focus:border-error-800':
                                    errors.month,
                            }"
                        >
                            <option value="" disabled selected>Select Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
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

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.month">{{ errors.month }}</p>
                </div>

                <div class="w-1/4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Year </label>
                    <div class="relative z-20 bg-transparent">
                        <select
                            v-model="formData.year"
                            class="dark:bg-dark-900 shadow-theme-xs w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            :class="{
                                'text-gray-800 dark:text-white/90': formData.year,
                                'border-error-300 focus:border-error-300 focus:ring-error-500/10 dark:border-error-700 dark:focus:border-error-800':
                                    errors.year,
                            }"
                        >
                            <option value="" disabled selected>Select Year</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
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

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.year">{{ errors.year }}</p>
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
            <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.details">{{ errors.details }}</p>
        </Card>

        <template v-if="details.length > 0">
            <template v-for="(detail, index) in details" :key="index">
                <Card :title="`Create Detail - ${index + 1}`" class="mt-5">
                    <div class="flex w-full gap-5 space-y-6">
                        <div class="w-1/4">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Plan </label>
                            <div class="relative z-20 bg-transparent">
                                <select
                                    v-model="detail.plan_detail_id"
                                    class="dark:bg-dark-900 shadow-theme-xs w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                >
                                    <option value="" disabled selected>Select Plan</option>
                                    <optgroup v-for="(plan, index) of plans" :key="plan.id" :label="`Plan ${index + 1}`">
                                        <option v-for="detail of plan.detail" :key="detail.id" :value="detail.id">{{ detail.name }}</option>
                                    </optgroup>
                                </select>
                                <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg
                                        class="stroke-current"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
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
                        </div>
                        <div class="w-1/4">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Budget </label>
                            <div class="relative z-20 bg-transparent">
                                <select
                                    v-model="detail.budget_detail_id"
                                    class="dark:bg-dark-900 shadow-theme-xs w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                >
                                    <option value="" disabled selected>Select Budget</option>
                                    <optgroup v-for="(budget, index) of budgets" :key="budget.id" :label="`Budget ${index + 1}`">
                                        <option v-for="detail of budget.detail" :key="detail.id" :value="detail.id">{{ detail.name }}</option>
                                    </optgroup>
                                </select>
                                <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg
                                        class="stroke-current"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
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
                        </div>
                    </div>
                    <div class="flex w-full gap-5 space-y-6">
                        <div class="w-1/6">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Qty </label>
                            <div class="relative z-20 bg-transparent">
                                <Input
                                    id="qty"
                                    type="number"
                                    required
                                    autofocus
                                    :tabindex="1"
                                    autocomplete="qty"
                                    v-model="detail.qty"
                                    placeholder="Qty"
                                />
                            </div>
                        </div>

                        <div class="w-1/6">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Unit </label>
                            <div class="relative z-20 bg-transparent">
                                <select
                                    v-model="detail.unit_id"
                                    class="dark:bg-dark-900 shadow-theme-xs w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                >
                                    <option value="" disabled selected>Select Unit</option>
                                    <option v-for="unit of units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
                                </select>
                                <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg
                                        class="stroke-current"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
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
                                    v-model="detail.price"
                                    placeholder="Price"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="flex w-full gap-5 space-y-6">
                        <div class="w-1/2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Note </label>
                            <div class="relative z-20 bg-transparent">
                                <textarea
                                    id="note"
                                    class="dark:bg-dark-900 shadow-theme-xs w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    v-model="detail.note"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                    <ButtonAction size="sm" variant="outline" @click="remove(detail.id)">Remove</ButtonAction>
                </Card>
            </template>
        </template>
        <div class="my-5 w-full">
            <ButtonAction class="w-full" size="sm" variant="outline" @click="add()">Add Detail</ButtonAction>
        </div>
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
import { reactive, ref } from 'vue';
import { useToast } from 'vue-toastification';

interface BudgetDetail {
    id: number;
    name: string;
    precentage: number;
    nominal: number;
}

interface Budget {
    id: number;
    month: number;
    year: string;
    initial_balance: number;
    detail: Array<BudgetDetail>;
}

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
    month: string;
    year: string;
    image: string;
    details: string;
}

interface Detail {
    id: number;
    plan_detail_id: number | null;
    budget_detail_id: number;
    unit_id: number;
    note: string;
    qty: number;
    price: number;
}

interface Props {
    errors: Errors;
    plans: Array<Plan>;
    budgets: Array<Budget>;
    units: Array<Unit>;
}

interface Input {
    month: number;
    year: number;
    image: File | null;
}

const toast = useToast();
const swal = useSwal();

const formData = reactive<Input>({
    month: 0,
    year: 0,
    image: null,
});

const details = ref<Detail[]>([]);

const add = () => {
    details.value = [
        ...details.value,
        {
            id: new Date().getTime(),
            plan_detail_id: null,
            budget_detail_id: 0,
            unit_id: 0,
            note: '',
            qty: 0,
            price: 0,
        },
    ];
};

const remove = (id: number): void => {
    details.value = details.value.filter((element) => element.id !== id);
};

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
                month: formData.month,
                year: formData.year,
                image: formData.image,
                details: details.value,
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
