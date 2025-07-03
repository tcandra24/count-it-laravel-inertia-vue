<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Units'"></Breadcrumb>
        <Card title="List of Units">
            <ButtonAction v-if="can(['master.units.create'])" size="sm" variant="primary" :startIcon="PlusIcon" :onClick="href">Add</ButtonAction>
            <TableList>
                <template #header>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="w-3/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Name</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Action</p>
                        </th>
                    </tr>
                </template>
                <template #body>
                    <template v-if="units.length > 0">
                        <tr v-for="(unit, index) in units" :key="index" class="border-t border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ unit.name }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex gap-2">
                                    <Link v-if="can(['master.units.edit'])" :href="`/master/units/${unit.id}/edit`">
                                        <Button size="sm" variant="outline" :startIcon="PencilIcon" />
                                    </Link>
                                    <Button
                                        v-if="can(['master.units.destroy'])"
                                        size="sm"
                                        variant="outline"
                                        :startIcon="TrashIcon"
                                        :onClick="() => destroy(unit.id)"
                                    />
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="6" class="px-5 py-4 sm:px-6">
                                <Alert variant="info" title="No Units Data" message="Units is Empty or Not Found" :showLink="false" />
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

import { usePermissions } from '@/composables/usePermissions';
import { useSwal } from '@/composables/useSwal';
import { useToast } from 'vue-toastification';

interface Unit {
    id: number;
    name: string;
}

interface Props {
    units: Array<Unit>;
}

const href = () => {
    router.visit('/master/units/create');
};

const toast = useToast();
const swal = useSwal();
const { can } = usePermissions();

const destroy = async (id: number): Promise<void> => {
    const result = await swal.fire({
        title: 'Do you want to delete the unit?',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete it',
        icon: 'question',
        confirmButtonColor: '#465fff',
    });

    if (result.isConfirmed) {
        router.delete(`/master/units/${id}`, {
            onSuccess: () => {
                toast.success('Unit Delete Successfully!');
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
