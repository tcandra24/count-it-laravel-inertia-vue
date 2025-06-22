<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Realizations'"></Breadcrumb>
        <Card title="List of Realizations">
            <ButtonAction size="sm" variant="primary" :startIcon="PlusIcon" :onClick="href">Add</ButtonAction>
            <TableList>
                <template #header>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="w-3/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Plan</p>
                        </th>
                        <th class="w-3/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Period</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Qty</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Price</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Total</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Action</p>
                        </th>
                    </tr>
                </template>
                <template #body>
                    <template v-if="realizations.length > 0">
                        <tr v-for="(realization, index) in realizations" :key="index" class="border-t border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 font-bold sm:px-6">
                                {{ realization.plan_detail ? realization.plan_detail.name : 'Other' }}
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ realization.month }} / {{ realization.year }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ realization.qty }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ moneyFormat(realization.price) }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ moneyFormat(realization.total) }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex gap-2">
                                    <Link :href="`/realizations/${realization.id}/edit`">
                                        <Button size="sm" variant="outline" :startIcon="PencilIcon" />
                                    </Link>
                                    <Button size="sm" variant="outline" :startIcon="TrashIcon" :onClick="() => destroy(realization.id)" />
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="6" class="px-5 py-4 sm:px-6">
                                <Alert variant="info" title="No Realizations Data" message="Realizations is Empty or Not Found" :showLink="false" />
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
import { PencilIcon, PlusIcon, TrashIcon } from '@/icons';
import DefaultLayout from '@/layouts/Default.vue';

import { moneyFormat } from '@/composables/useHelpers';

import { Link, router } from '@inertiajs/vue3';

import { useSwal } from '@/composables/useSwal';
import { useToast } from 'vue-toastification';

interface User {
    name: string;
}

interface Plan {
    id: number;
    month: number;
    year: number;
    is_active: number;
    user: User;
}

interface PlanDetail {
    plan: Plan;
    name: string;
    qty: number;
    price: number;
    total: number;
}

interface Realizations {
    id: number;
    plan_detail: PlanDetail | null;
    qty: number;
    price: number;
    total: number;
    image: string;
    month: number;
    year: number;
}

interface Props {
    realizations: Array<Realizations>;
}

const href = () => {
    router.visit('realizations/create');
};

const toast = useToast();
const swal = useSwal();

const destroy = async (id: number): Promise<void> => {
    const result = await swal.fire({
        title: 'Do you want to delete the realization?',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete it',
        icon: 'question',
        confirmButtonColor: '#465fff',
    });

    if (result.isConfirmed) {
        router.delete(`/realizations/${id}`, {
            onSuccess: () => {
                toast.success('Realization Delete Successfully!');
            },
            onError: (error) => {
                console.log(error);
                toast.error(`Something went wrong!!`);
            },
        });
    }
};

defineProps<Props>();
</script>
