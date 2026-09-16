<template>
    <div
        class="bg-white rounded-[24px] p-6 border border-[#CFD6C4]/50 shadow-[0_4px_20px_rgba(101,113,102,0.08)] relative overflow-hidden flex flex-col justify-between"
        :class="[
            variantClass,
            customClass
        ]"
    >
        <!-- Background decorative soft shape -->
        <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full opacity-35 pointer-events-none" :class="decoBgClass"></div>

        <div class="flex items-start justify-between relative z-10">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-[#657166]/70">{{ label }}</span>
                <h3 class="text-2xl font-bold text-[#657166] mt-1 font-sans">{{ value }}</h3>
            </div>
            <div
                class="w-12 h-12 rounded-[16px] flex items-center justify-center shadow-inner"
                :class="iconBgClass"
            >
                <slot name="icon">
                    <span class="text-xl font-bold text-[#657166]">✦</span>
                </slot>
            </div>
        </div>

        <div v-if="subtext || trend" class="mt-4 pt-3 border-t border-[#CFD6C4]/30 flex items-center justify-between text-xs text-[#657166]/80 relative z-10">
            <span>{{ subtext }}</span>
            <span v-if="trend" class="font-semibold px-2 py-0.5 rounded-full bg-[#DAEBE3] text-[#2D3A30]">{{ trend }}</span>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    subtext: {
        type: String,
        default: '',
    },
    trend: {
        type: String,
        default: '',
    },
    color: {
        type: String,
        default: 'mint', // 'mint' | 'blue' | 'coral' | 'cream' | 'sage'
    },
    customClass: {
        type: String,
        default: '',
    },
});

const variantClass = computed(() => {
    switch (props.color) {
        case 'mint': return 'hover:border-[#DAEBE3]';
        case 'blue': return 'hover:border-[#99CDD8]';
        case 'coral': return 'hover:border-[#F3C3B2]';
        default: return 'hover:border-[#CFD6C4]';
    }
});

const iconBgClass = computed(() => {
    switch (props.color) {
        case 'mint': return 'bg-[#DAEBE3] text-[#2D3A30]';
        case 'blue': return 'bg-[#99CDD8] text-[#2D3A30]';
        case 'coral': return 'bg-[#F3C3B2] text-[#4A3525]';
        case 'cream': return 'bg-[#FDE8D3] text-[#4A3525]';
        default: return 'bg-[#CFD6C4]/50 text-[#657166]';
    }
});

const decoBgClass = computed(() => {
    switch (props.color) {
        case 'mint': return 'bg-[#DAEBE3]';
        case 'blue': return 'bg-[#99CDD8]';
        case 'coral': return 'bg-[#F3C3B2]';
        case 'cream': return 'bg-[#FDE8D3]';
        default: return 'bg-[#CFD6C4]';
    }
});
</script>
