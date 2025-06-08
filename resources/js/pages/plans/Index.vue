<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Plans'"></Breadcrumb>
        <Card title="List of Plans">
            <ButtonAction size="sm" variant="primary" :startIcon="PlusIcon" :onClick="href">Add</ButtonAction>
            <TableList>
                <template #header>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="w-3/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Month</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Year</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">User</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Action</p>
                        </th>
                    </tr>
                </template>
                <template #body>
                    <template v-if="plans.length > 0">
                        <tr v-for="(plan, index) in plans" :key="index" class="border-t border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ monthName(plan.month) }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ plan.year }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ plan.user.name }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex gap-2">
                                    <Link :href="`/plans/${plan.id}/edit`">
                                        <Button size="sm" variant="outline" :startIcon="PencilIcon" />
                                    </Link>
                                    <Button size="sm" variant="outline" :startIcon="TrashIcon" :onClick="() => destroy(plan.id)" />
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="4" class="px-5 py-4 sm:px-6">
                                <Alert variant="info" title="No Plans Data" message="Plans is Empty or Not Found" :showLink="false" />
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

import { Link, router } from '@inertiajs/vue3';

import { useSwal } from '@/composables/useSwal';

interface User {
    name: string;
}

interface Plans {
    id: number;
    month: number;
    year: number;
    is_active: number;
    user: User;
}

interface Props {
    plans: Array<Plans>;
}

const href = () => {
    router.visit('plans/create');
};

const swal = useSwal();

const destroy = async (id: number): Promise<void> => {
    const result = await swal.fire({
        title: 'Do you want to delete the plan?',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete it',
        icon: 'question',
        confirmButtonColor: '#465fff',
    });

    if (result.isConfirmed) {
        router.delete(`/plans/${id}`);
    }
};

defineProps<Props>();
</script>
