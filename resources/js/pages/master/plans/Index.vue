<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Plans'"></Breadcrumb>
        <Card title="List of Plans">
            <ButtonAction v-if="can(['master.plans.create'])" size="sm" variant="primary" :startIcon="PlusIcon" :onClick="href">Add</ButtonAction>
            <TableList>
                <template #header>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="w-3/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Category</p>
                        </th>
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
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ plan.category.name }}</p>
                            </td>
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
                                    <Link :href="`/master/plans/${plan.id}`">
                                        <Button size="sm" variant="outline" :startIcon="EyeIcon" />
                                    </Link>
                                    <Link v-if="can(['master.plans.edit'])" :href="`/master/plans/${plan.id}/edit`">
                                        <Button size="sm" variant="outline" :startIcon="PencilIcon" />
                                    </Link>
                                    <Button
                                        v-if="can(['master.plans.destroy'])"
                                        size="sm"
                                        variant="outline"
                                        :startIcon="TrashIcon"
                                        :onClick="() => destroy(plan.id)"
                                    />
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="5" class="px-5 py-4 sm:px-6">
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
import { EyeIcon, PencilIcon, PlusIcon, TrashIcon } from '@/icons';
import DefaultLayout from '@/layouts/Default.vue';

import { Link, router } from '@inertiajs/vue3';

import { monthName } from '@/composables/useHelpers';
import { usePermissions } from '@/composables/usePermissions';
import { useSwal } from '@/composables/useSwal';
import { useToast } from 'vue-toastification';

interface User {
    name: string;
}

interface Category {
    name: string;
}

interface Plans {
    id: number;
    category: Category;
    month: number;
    year: number;
    is_active: number;
    user: User;
}

interface Props {
    plans: Array<Plans>;
}

const href = () => {
    router.visit('/master/plans/create');
};

const toast = useToast();
const swal = useSwal();
const { can } = usePermissions();

const destroy = async (id: number): Promise<void> => {
    const result = await swal.fire({
        title: 'Do you want to delete the plan?',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete it',
        icon: 'question',
        confirmButtonColor: '#465fff',
    });

    if (result.isConfirmed) {
        router.delete(`/master/plans/${id}`, {
            onSuccess: () => {
                toast.success('Plan Delete Successfully!');
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
