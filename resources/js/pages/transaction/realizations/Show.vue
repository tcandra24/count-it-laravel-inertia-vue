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
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Plan</p>
                            <p class="mb-2 text-sm font-medium text-gray-800 dark:text-white/90">
                                {{ realization.plan_detail ? realization.plan_detail.name : 'Other' }}
                            </p>
                            <Badge v-if="realization.plan_detail" color="success">
                                {{ realization.plan_detail.plan.category.name }}
                            </Badge>
                        </div>
                    </div>

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
                <div class="flex w-full space-y-6">
                    <div class="w-1/4">
                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Name</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ realization.name }}</p>
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Note</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ realization.note }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex w-full space-y-6">
                    <div class="w-1/4">
                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Qty</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ realization.qty }}</p>
                        </div>
                    </div>
                    <div class="w-1/4">
                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Price</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ moneyFormat(realization.price) }}</p>
                        </div>
                    </div>
                    <div class="w-1/4">
                        <div>
                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Total</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ moneyFormat(realization.qty * realization.price) }}</p>
                        </div>
                    </div>
                </div>
            </Card>
        </div>
    </DefaultLayout>
</template>

<script setup lang="ts">
import Badge from '@/components/Badge.vue';
import Breadcrumb from '@/components/Breadcrumb.vue';
import Card from '@/components/Card.vue';
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
    name: string;
    note: string;
    qty: number;
    image: string;
    price: number;
    month: number;
    year: number;
    plan_detail: PlanDetail;
}

interface Props {
    realization: Realization;
    errors: Errors;
}

defineProps<Props>();
</script>
