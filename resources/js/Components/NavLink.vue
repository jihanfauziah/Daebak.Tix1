<template>
    <Link
        :href="href"
        class="flex items-center gap-3 px-4 py-3 rounded-[16px] text-sm transition-all duration-150 group"
        :class="[
            active
                ? 'bg-[#99CDD8] text-[#2D3A30] font-semibold shadow-[0_2px_8px_rgba(153,205,216,0.3)]'
                : 'text-[#657166] hover:bg-[#DAEBE3]/50 font-medium'
        ]"
    >
        <span class="text-lg transition-transform group-hover:scale-110">
            <slot name="icon" />
        </span>
        <span class="truncate"><slot /></span>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
});
</script>
