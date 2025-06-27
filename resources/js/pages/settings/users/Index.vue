<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Users'"></Breadcrumb>
        <Card title="List of Users">
            <ButtonAction v-if="can(['setting.users.create'])" size="sm" variant="primary" :startIcon="PlusIcon" :onClick="href">Add</ButtonAction>
            <TableList>
                <template #header>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="w-3/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Name</p>
                        </th>
                        <th class="w-3/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Email</p>
                        </th>
                        <th class="w-3/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Roles</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Action</p>
                        </th>
                    </tr>
                </template>
                <template #body>
                    <template v-if="users.length > 0">
                        <tr v-for="(user, index) in users" :key="index" class="border-t border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ user.name }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ user.email }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex flex-wrap gap-1">
                                    <Badge v-for="(role, index) in user.roles" :key="index">
                                        {{ role.name }}
                                    </Badge>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex gap-2">
                                    <Link v-if="can(['setting.users.edit'])" :href="`/setting/users/${user.id}/edit`">
                                        <Button size="sm" variant="outline" :startIcon="PencilIcon" />
                                    </Link>
                                    <Button
                                        v-if="can(['setting.users.destroy'])"
                                        size="sm"
                                        variant="outline"
                                        :startIcon="TrashIcon"
                                        :onClick="() => destroy(user.id)"
                                    />
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="6" class="px-5 py-4 sm:px-6">
                                <Alert variant="info" title="No Users Data" message="Users is Empty or Not Found" :showLink="false" />
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
import Badge from '@/components/Badge.vue';
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

interface Role {
    id: number;
    name: string;
}

interface User {
    id: number;
    name: string;
    email: string;
    roles: Array<Role>;
}

interface Props {
    users: Array<User>;
}

const href = () => {
    router.visit('users/create');
};

const toast = useToast();
const swal = useSwal();
const { can } = usePermissions();

const destroy = async (id: number): Promise<void> => {
    const result = await swal.fire({
        title: 'Do you want to delete the user?',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete it',
        icon: 'question',
        confirmButtonColor: '#465fff',
    });

    if (result.isConfirmed) {
        router.delete(`/setting/users/${id}`, {
            onSuccess: () => {
                toast.success('User Delete Successfully!');
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
