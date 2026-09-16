<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-50 overflow-y-auto bg-[#657166]/40 backdrop-blur-sm flex items-center justify-center p-4"
                @click.self="close"
            >
                <div
                    class="bg-white rounded-[24px] border border-[#CFD6C4]/60 shadow-[0_10px_40px_rgba(101,113,102,0.18)] w-full max-w-lg overflow-hidden transform transition-all"
                    :class="maxWidthClass"
                >
                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b border-[#CFD6C4]/40 flex items-center justify-between bg-[#FDE8D3]/30">
                        <h3 class="font-sans font-bold text-lg text-[#657166]">
                            <slot name="title">{{ title }}</slot>
                        </h3>
                        <button
                            @click="close"
                            class="w-8 h-8 rounded-full bg-[#CFD6C4]/40 text-[#657166] hover:bg-[#CFD6C4] flex items-center justify-center transition-colors"
                        >
                            ✕
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <slot />
                    </div>

                    <!-- Modal Footer -->
                    <div v-if="$slots.footer" class="px-6 py-4 bg-[#FDE8D3]/20 border-t border-[#CFD6C4]/30 flex justify-end gap-3">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { computed, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        default: '',
    },
    maxWidth: {
        type: String,
        default: 'md', // 'sm' | 'md' | 'lg' | 'xl' | '2xl'
    },
});

const emit = defineEmits(['close']);

const close = () => {
    emit('close');
};

const maxWidthClass = computed(() => {
    switch (props.maxWidth) {
        case 'sm': return 'max-w-sm';
        case 'md': return 'max-w-md';
        case 'lg': return 'max-w-lg';
        case 'xl': return 'max-w-xl';
        case '2xl': return 'max-w-2xl';
        default: return 'max-w-lg';
    }
});
</script>
