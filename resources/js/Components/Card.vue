<template>
    <div
        class="bg-white rounded-[24px] border border-[#CFD6C4]/50 shadow-[0_4px_20px_rgba(101,113,102,0.08)] transition-all duration-200"
        :class="[
            hoverable ? 'hover:-translate-y-0.5 hover:shadow-[0_8px_30px_rgba(101,113,102,0.14)]' : '',
            paddingClass,
            customClass
        ]"
    >
        <div v-if="$slots.header" class="border-b border-[#CFD6C4]/40 pb-4 mb-5">
            <slot name="header" />
        </div>
        <div>
            <slot />
        </div>
        <div v-if="$slots.footer" class="border-t border-[#CFD6C4]/40 pt-4 mt-5">
            <slot name="footer" />
        </div>
    </div>
</template>

<script setup>
defineProps({
    hoverable: {
        type: Boolean,
        default: false,
    },
    paddingClass: {
        type: String,
        default: 'p-6',
    },
    customClass: {
        type: String,
        default: '',
    },
});
</script>
