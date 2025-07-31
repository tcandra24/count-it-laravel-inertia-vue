<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Edit Budget'"></Breadcrumb>
        <Card title="Edit">
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
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Initial Balance </label>
                    <div class="relative z-20 bg-transparent">
                        <Input
                            id="initial_balance"
                            type="number"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="initial_balance"
                            v-model="formData.initial_balance"
                            placeholder="Initial Balance"
                            :disabled="details.length > 0"
                        />
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.initial_balance">{{ errors.initial_balance }}</p>
                </div>
            </div>
            <ButtonAction size="sm" variant="primary" @click="submit">Submit</ButtonAction>
        </Card>
        <Card title="List of Detail" class="mt-5">
            <ButtonAction size="sm" variant="primary" @click="add()">Add Detail</ButtonAction>
            <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.details">{{ errors.details }}</p>
            <TableList
                :class="{
                    '!border-error-300 dark:!border-error-700': errors.details,
                }"
            >
                <template #header>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="w-3/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Name</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Precentage</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Nominal</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Action</p>
                        </th>
                    </tr>
                </template>
                <template #body>
                    <template v-if="details.length > 0">
                        <tr v-for="(detail, index) in details" :key="index" class="border-t border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 sm:px-6">
                                <Input
                                    id="name"
                                    type="text"
                                    required
                                    autofocus
                                    :tabindex="1"
                                    autocomplete="name"
                                    v-model="detail.name"
                                    placeholder="Name"
                                />
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <Input
                                    id="precentage"
                                    type="number"
                                    required
                                    autofocus
                                    :tabindex="1"
                                    autocomplete="precentage"
                                    v-model="detail.precentage"
                                    placeholder="Precentage"
                                    min="1"
                                    max="100"
                                    @input="detail.nominal = countPrecentage(detail.precentage)"
                                />
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ moneyFormat(detail.nominal) }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <Button size="sm" variant="outline" :startIcon="TrashIcon" :onClick="() => remove(detail.id)" />
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="5" class="px-5 py-4 sm:px-6">
                                <Alert variant="info" title="No Budgets Data" message="Budget is Empty or Not Found" :showLink="false" />
                            </td>
                        </tr>
                    </template>
                </template>
            </TableList>
        </Card>
    </DefaultLayout>
</template>

<script setup lang="ts">
import Alert from '@/components/Alert.vue';
import Breadcrumb from '@/components/Breadcrumb.vue';
import Button from '@/components/Button.vue';
import ButtonAction from '@/components/ButtonAction.vue';
import Card from '@/components/Card.vue';
import TableList from '@/components/TableList.vue';
import { Input } from '@/components/ui/input';
import { TrashIcon } from '@/icons';
import DefaultLayout from '@/layouts/Default.vue';

import { useSwal } from '@/composables/useSwal';
import { router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import { useToast } from 'vue-toastification';

import { moneyFormat } from '@/composables/useHelpers';

interface Errors {
    month: string;
    year: string;
    details: string;
    initial_balance: string;
}

interface Detail {
    id: number;
    name: string;
    precentage: number;
    nominal: number;
}

interface Budget {
    id: number;
    month: number;
    year: number;
    initial_balance: number;
    detail: Array<Detail>;
}

interface Props {
    errors: Errors;
    budget: Budget;
}

const toast = useToast();
const swal = useSwal();

const props = defineProps<Props>();

const formData = reactive({
    month: props.budget.month,
    year: props.budget.year,
    initial_balance: props.budget.initial_balance,
});

const details = ref<Detail[]>(props.budget.detail);

const add = () => {
    details.value = [
        ...details.value,
        {
            id: new Date().getTime(),
            name: '',
            precentage: 0,
            nominal: 0,
        },
    ];
};

const remove = (id: number): void => {
    details.value = details.value.filter((element) => element.id !== id);
};

const countPrecentage = (value: number): number => {
    if (formData.initial_balance === 0) {
        return 0;
    }

    if (value > 100) {
        return 0;
    }

    return (value / 100) * formData.initial_balance;
};

const submit = async (): Promise<void> => {
    const result = await swal.fire({
        title: 'Do you want to save the budget?',
        showCancelButton: true,
        confirmButtonText: 'Yes, Save it',
        icon: 'question',
        confirmButtonColor: '#465fff',
    });

    if (result.isConfirmed) {
        router.put(
            `/transaction/budgets/${props.budget.id}`,
            {
                month: formData.month,
                year: formData.year,
                initial_balance: formData.initial_balance,
                details: details.value,
            },
            {
                onSuccess: () => {
                    toast.success('Budget Updated Successfully!');
                },
                onError: (error) => {
                    console.log(error);
                    toast.error(`Something went wrong!!`);
                },
            },
        );
    }
};
</script>
