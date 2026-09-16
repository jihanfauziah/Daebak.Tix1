<template>
    <component
        :is="href ? Link : 'button'"
        :href="href"
        :type="href ? undefined : type"
        :disabled="disabled || loading"
        class="inline-flex items-center justify-center font-sans font-semibold text-[15px] rounded-[16px] px-5 py-2.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#99CDD8] focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed shadow-[0_2px_8px_rgba(153,205,216,0.35)]"
        :class="[
            'bg-[#99CDD8] text-[#2D3A30] hover:bg-[#88bcc7] hover:shadow-[0_4px_14px_rgba(153,205,216,0.45)] active:scale-[0.98]',
            customClass
        ]"
    >
        <span v-if="loading" class="mr-2 inline-block w-4 h-4 border-2 border-[#2D3A30] border-t-transparent rounded-full animate-spin"></span>
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
