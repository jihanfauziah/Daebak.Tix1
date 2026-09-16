<template>
    <component
        :is="href ? Link : 'button'"
        :href="href"
        :type="href ? undefined : type"
        :disabled="disabled || loading"
        class="inline-flex items-center justify-center font-sans font-semibold text-[15px] rounded-[16px] px-5 py-2.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#F3C3B2] focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed shadow-[0_2px_8px_rgba(243,195,178,0.35)]"
        :class="[
            variant === 'mint'
                ? 'bg-[#DAEBE3] text-[#2D3A30] hover:bg-[#c9e0d6] focus:ring-[#DAEBE3]'
                : 'bg-[#F3C3B2] text-[#4A3525] hover:bg-[#e2b2a1] focus:ring-[#F3C3B2]',
            customClass
        ]"
    >
        <span v-if="loading" class="mr-2 inline-block w-4 h-4 border-2 border-current border-t-transparent rounded-full animate-spin"></span>
        <slot />
    </component>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    type: {
        type: String,
        default: 'button',
    },
    href: {
        type: String,
        default: null,
    },
    variant: {
        type: String,
        default: 'coral', // 'coral' | 'mint'
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    loading: {
        type: Boolean,
        default: false,
    },
    customClass: {
        type: String,
        default: '',
    },
});
</script>
