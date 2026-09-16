<template>
    <component
        :is="href ? Link : 'button'"
        :href="href"
        :type="href ? undefined : type"
        :disabled="disabled || loading"
        class="inline-flex items-center justify-center font-sans font-semibold text-[15px] rounded-[16px] px-5 py-2.5 bg-[#657166] text-white hover:bg-[#535e54] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#657166] focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed shadow-[0_2px_8px_rgba(101,113,102,0.25)] active:scale-[0.98]"
        :class="customClass"
    >
        <span v-if="loading" class="mr-2 inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
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
