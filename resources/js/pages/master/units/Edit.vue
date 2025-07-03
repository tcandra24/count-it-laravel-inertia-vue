<template>
    <DefaultLayout>
        <Breadcrumb :pageTitle="'Edit Unit'"></Breadcrumb>
        <Card title="Edit">
            <div class="flex w-full gap-5 space-y-6">
                <div class="w-1/4">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Name </label>
                    <div class="relative z-20 bg-transparent">
                        <Input
                            id="name"
                            type="text"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="name"
                            v-model="formData.name"
                            placeholder="Name"
                        />
                    </div>

                    <p class="text-theme-xs text-error-500 mt-1.5" v-if="errors.name">{{ errors.name }}</p>
                </div>
            </div>
            <ButtonAction size="sm" variant="primary" @click="submit">Submit</ButtonAction>
        </Card>
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
import { reactive } from 'vue';
import { useToast } from 'vue-toastification';

interface Errors {
    name: string;
}

interface Unit {
    id: number;
    name: string;
}

interface Props {
    errors: Errors;
    unit: Unit;
}

interface Input {
    name: string;
}

const toast = useToast();
const swal = useSwal();

const props = defineProps<Props>();

const formData = reactive<Input>({
    name: props.unit.name,
});

const submit = async (): Promise<void> => {
    const result = await swal.fire({
        title: 'Do you want to save the category?',
        showCancelButton: true,
        confirmButtonText: 'Yes, Save it',
        icon: 'question',
        confirmButtonColor: '#465fff',
    });

    if (result.isConfirmed) {
        router.put(
            `/master/units/${props.unit.id}`,
            {
                name: formData.name,
            },
            {
                onSuccess: () => {
                    toast.success('Unit Updated Successfully!');
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
