<template>
    <div class="w-full">
        <label v-if="label" :for="id" class="block text-sm font-medium text-[#657166] mb-1.5 font-sans">
            {{ label }}
            <span v-if="required" class="text-[#E76F51]">*</span>
        </label>
        <div class="relative rounded-[8px]">
            <input
                :id="id"
                :type="type"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                :placeholder="placeholder"
                :required="required"
                :disabled="disabled"
                :min="min"
                :max="max"
                :step="step"
                class="w-full bg-white text-[#657166] placeholder-[#657166]/40 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-[15px] font-sans transition-all duration-150 focus:outline-none focus:border-[#99CDD8] focus:ring-3 focus:ring-[#99CDD8]/25 disabled:bg-[#CFD6C4]/20 disabled:cursor-not-allowed"
                :class="[
                    error ? 'border-[#E76F51] focus:border-[#E76F51] focus:ring-[#E76F51]/20' : '',
                    customInputClass
                ]"
            />
            <div v-if="$slots.suffix" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-[#657166]/60">
                <slot name="suffix" />
            </div>
        </div>
        <p v-if="error" class="mt-1 text-xs text-[#E76F51] font-sans font-medium">{{ error }}</p>
        <p v-else-if="helpText" class="mt-1 text-xs text-[#657166]/70 font-sans">{{ helpText }}</p>
    </div>
</template>

<script setup>
defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
    label: {
        type: String,
        default: '',
    },
    id: {
        type: String,
        default: () => 'input-' + Math.random().toString(36).substring(2, 9),
    },
    type: {
        type: String,
        default: 'text',
    },
    placeholder: {
        type: String,
        default: '',
    },
    required: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    error: {
        type: String,
        default: '',
    },
    helpText: {
        type: String,
        default: '',
    },
    min: {
        type: [String, Number],
        default: undefined,
    },
    max: {
        type: [String, Number],
        default: undefined,
    },
    step: {
        type: [String, Number],
        default: undefined,
    },
    customInputClass: {
        type: String,
        default: '',
    },
});

defineEmits(['update:modelValue']);
</script>
