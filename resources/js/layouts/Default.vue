<template>
    <div class="min-h-screen xl:flex">
        <app-sidebar />
        <Backdrop />
        <div class="flex-1 transition-all duration-300 ease-in-out" :class="[isExpanded || isHovered ? 'lg:ml-[290px]' : 'lg:ml-[90px]']">
            <app-header />
            <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppHeader from '../components/AppHeader.vue';
import AppSidebar from '../components/AppSidebar.vue';
import { useSidebar } from '../composables/useSidebar';
import Backdrop from './Backdrop.vue';

const { isExpanded, isHovered } = useSidebar();
</script>
