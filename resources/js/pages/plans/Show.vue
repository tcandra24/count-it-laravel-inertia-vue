<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Show Plans'"></Breadcrumb>
        <Card title="Detail Plan">
            <div class="flex w-full space-y-6">
                <!-- Select Input -->
                <div class="w-1/4">
                    <div>
                        <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Month</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ monthName(plan.month) }}</p>
                    </div>
                </div>

                <div class="w-1/4">
                    <div>
                        <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Year</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ plan.year }}</p>
                    </div>
                </div>
            </div>
        </Card>
        <Card title="List of Detail" class="mt-5">
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
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Qty</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Price</p>
                        </th>
                        <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Total</p>
                        </th>
                    </tr>
                </template>
                <template #body>
                    <template v-if="details.length > 0">
                        <tr v-for="(detail, index) in details" :key="index" class="border-t border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm font-bold text-black dark:text-white">{{ detail.name }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ detail.qty }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ moneyFormat(detail.price) }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ moneyFormat(detail.qty * detail.price) }}</p>
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
import Card from '@/components/Card.vue';
import TableList from '@/components/TableList.vue';
import DefaultLayout from '@/layouts/Default.vue';

import { moneyFormat, monthName } from '@/composables/useHelpers';

import { ref } from 'vue';

interface Detail {
    id: number;
    name: string;
    qty: number;
    price: number;
}

interface Errors {
    month: string;
    details: string;
    year: string;
}

interface Plans {
    id: number;
    month: number;
    year: number;
    is_active: number;
    detail: Array<Detail>;
}

interface Props {
    plan: Plans;
    errors: Errors;
}

const props = defineProps<Props>();

const details = ref<Detail[]>(props.plan.detail);
</script>
