<template>
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold tracking-wide transition-colors"
        :class="variantClasses"
    >
        <span v-if="dot" class="w-1.5 h-1.5 rounded-full" :class="dotClasses"></span>
        <slot />
    </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'default', // 'success' | 'warning' | 'danger' | 'info' | 'mint' | 'coral' | 'blue' | 'default'
    },
    dot: {
        type: Boolean,
        default: false,
    },
});

const variantClasses = computed(() => {
    switch (props.variant) {
        case 'success':
        case 'valid':
        case 'paid':
        case 'approved':
        case 'verified':
        case 'active':
            return 'bg-[#DAEBE3] text-[#1E4D38] border border-[#DAEBE3]';
        case 'warning':
        case 'pending':
        case 'pending_review':
        case 'used':
            return 'bg-[#FDE8D3] text-[#8C4E37] border border-[#F3C3B2]/60';
        case 'danger':
        case 'error':
        case 'rejected':
        case 'cancelled':
        case 'expired':
            return 'bg-[#FADBD8] text-[#900C3F] border border-[#F5B7B1]';
        case 'info':
        case 'blue':
            return 'bg-[#99CDD8]/40 text-[#1B4F72] border border-[#99CDD8]';
        case 'coral':
            return 'bg-[#F3C3B2]/50 text-[#6E2C00] border border-[#F3C3B2]';
        case 'mint':
            return 'bg-[#DAEBE3] text-[#1E4D38] border border-[#DAEBE3]';
        default:
            return 'bg-[#CFD6C4]/40 text-[#657166] border border-[#CFD6C4]';
    }
});

const dotClasses = computed(() => {
    switch (props.variant) {
        case 'success':
        case 'valid':
        case 'paid':
        case 'approved':
        case 'verified':
        case 'active':
            return 'bg-[#2E7D32]';
        case 'warning':
        case 'pending':
        case 'pending_review':
        case 'used':
            return 'bg-[#D97706]';
        case 'danger':
        case 'error':
        case 'rejected':
        case 'cancelled':
        case 'expired':
            return 'bg-[#C0392B]';
        case 'info':
        case 'blue':
            return 'bg-[#2980B9]';
        default:
            return 'bg-[#657166]';
    }
});
</script>
