<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Show Realization'"></Breadcrumb>
        <div className="space-y-5 sm:space-y-6">
            <Card title="Image Realization">
                <div class="flex w-full space-y-6">
                    <div class="w-1/2">
                        <div class="relative">
                            <div id="pane" class="overflow-hidden">
                                <img
                                    :src="realization.image"
                                    alt="Image Realization"
                                    class="w-full rounded-xl border border-gray-200 dark:border-gray-800"
                                />
                            </div>
                            <div id="ghostpane" class="absolute top-0 left-0 duration-300 ease-in-out"></div>
                        </div>
                    </div>
                </div>
            </Card>
            <Card title="Detail Realization">
                <div class="flex w-full space-y-6">
                    <div class="w-1/4">
                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Month</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ monthName(realization.month) }}</p>
                        </div>
                    </div>

                    <div class="w-1/4">
                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Year</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ realization.year }}</p>
                        </div>
                    </div>
                </div>
            </Card>
            <Card title="List of Detail" class="mt-5">
                <TableList>
                    <template #header>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="w-3/11 px-5 py-3 text-left sm:px-6">
                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Plan</p>
                            </th>
                            <th class="w-3/11 px-5 py-3 text-left sm:px-6">
                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Note</p>
                            </th>
                            <th class="w-2/11 px-5 py-3 text-left sm:px-6">
                                <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Budget</p>
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
                        <template v-if="realization.detail.length > 0">
                            <tr v-for="(detail, index) in realization.detail" :key="index" class="border-t border-gray-100 dark:border-gray-800">
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="mb-2 text-sm font-bold text-black dark:text-white/90">
                                        {{ detail.plan_detail ? detail.plan_detail.name : 'Other' }}
                                    </p>
                                    <Badge v-if="detail.plan_detail" color="success">
                                        {{ detail.plan_detail.plan.category.name }}
                                    </Badge>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ detail.note ?? '-' }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ detail.budget_detail.name }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ detail.qty }} {{ detail.unit.name }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ moneyFormat(detail.price) }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ moneyFormat(detail.total) }}</p>
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr>
                                <td colspan="6" class="px-5 py-4 sm:px-6">
                                    <Alert variant="info" title="No Budgets Data" message="Budget is Empty or Not Found" :showLink="false" />
                                </td>
                            </tr>
                        </template>
                    </template>
                </TableList>
            </Card>
        </div>
    </DefaultLayout>
</template>

<script setup lang="ts">
import Badge from '@/components/Badge.vue';
import Breadcrumb from '@/components/Breadcrumb.vue';
import Card from '@/components/Card.vue';
import TableList from '@/components/TableList.vue';
import DefaultLayout from '@/layouts/Default.vue';

import { moneyFormat, monthName } from '@/composables/useHelpers';

interface Errors {
    month: string;
    details: string;
    year: string;
}

interface Category {
    name: string;
}

interface Plan {
    id: number;
    category: Category;
    month: number;
    year: number;
    is_active: number;
}

interface PlanDetail {
    id: number;
    name: string;
    qty: number;
    price: number;
    plan: Plan;
}

interface Realization {
    id: number;
    month: number;
    year: number;
    image: string;
    detail: Array<RealizationDetail>;
}

interface Unit {
    id: number;
    name: string;
}

interface RealizationDetail {
    id: number;
    plan_detail: PlanDetail;
    budget_detail: BudgetDetail;
    unit: Unit;
    note: string;
    qty: number;
    price: number;
    total: number;
}

interface BudgetDetail {
    id: number;
    name: string;
    precentage: number;
    nominal: number;
}

interface Props {
    realization: Realization;
    errors: Errors;
}

defineProps<Props>();
</script>
