<template>
    <div class="min-h-screen bg-[#FDE8D3] flex flex-col font-sans text-[#657166]">
        <!-- Mobile Sidebar Backdrop -->
        <div
            v-if="mobileOpen"
            @click="mobileOpen = false"
            class="fixed inset-0 bg-[#657166]/50 z-40 lg:hidden backdrop-blur-xs"
        ></div>

        <!-- Unified Fixed Sidebar (260px) -->
        <aside
            class="fixed top-0 bottom-0 left-0 w-[260px] bg-white border-r border-[#CFD6C4]/50 z-50 flex flex-col justify-between transition-transform duration-300 lg:translate-x-0"
            :class="mobileOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full lg:translate-x-0'"
        >
            <!-- Sidebar Header / Logo -->
            <div>
                <div class="h-[72px] px-6 flex items-center justify-between border-b border-[#CFD6C4]/40 bg-[#FDE8D3]/30">
                    <Link href="/" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-[14px] bg-[#99CDD8] flex items-center justify-center font-heading text-xl text-[#2D3A30] shadow-sm group-hover:scale-105 transition-transform">
                            DT
                        </div>
                        <div>
                            <span class="font-heading text-xl text-[#657166] tracking-wide block leading-none">Daebak.Tix</span>
                            <span class="text-[11px] font-medium text-[#657166]/70 uppercase tracking-wider block mt-0.5">{{ roleTitle }}</span>
                        </div>
                    </Link>
                    <button
                        @click="mobileOpen = false"
                        class="lg:hidden w-8 h-8 rounded-full bg-[#CFD6C4]/40 text-[#657166] flex items-center justify-center"
                    >
                        ✕
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="p-4 space-y-1.5 overflow-y-auto max-h-[calc(100vh-170px)]">
                    <slot name="nav" />
                </nav>
            </div>

            <!-- Sidebar Footer / User Profile -->
            <div class="p-4 border-t border-[#CFD6C4]/40 bg-[#FDE8D3]/20">
                <div class="bg-white rounded-[18px] p-3 border border-[#CFD6C4]/40 flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-10 h-10 rounded-full bg-[#DAEBE3] text-[#2D3A30] font-bold flex items-center justify-center shrink-0 text-sm">
                            {{ userInitial }}
                        </div>
                        <div class="truncate">
                            <p class="font-semibold text-sm text-[#657166] truncate leading-tight">{{ authUser?.name || 'Pengguna' }}</p>
                            <span class="text-xs text-[#657166]/70 truncate block">{{ authUser?.email }}</span>
                        </div>
                    </div>
                    <form @submit.prevent="logout" class="shrink-0">
                        <button
                            type="submit"
                            title="Keluar"
                            class="w-8 h-8 rounded-[10px] bg-[#F3C3B2]/40 hover:bg-[#F3C3B2] text-[#8C4E37] flex items-center justify-center transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area: Left Margin 260px for Fixed Sidebar -->
        <div class="lg:pl-[260px] flex flex-col min-h-screen">
            <!-- Unified Fixed Topbar (72px) -->
            <header class="sticky top-0 z-30 h-[72px] bg-white/90 backdrop-blur-md border-b border-[#CFD6C4]/50 px-6 sm:px-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button
                        @click="mobileOpen = true"
                        class="lg:hidden p-2 rounded-xl bg-[#DAEBE3] text-[#657166]"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-xl font-bold text-[#657166] font-heading leading-tight">{{ title }}</h2>
                        <p v-if="subtitle" class="text-xs text-[#657166]/70 font-sans">{{ subtitle }}</p>
                    </div>
                </div>

                <!-- Topbar Actions Slot -->
                <div class="flex items-center gap-3">
                    <slot name="topbar-actions" />
                    <Link
                        href="/"
                        class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 rounded-[14px] bg-[#DAEBE3] text-[#2D3A30] text-xs font-semibold hover:bg-[#c9e0d6] transition-colors"
                    >
                        <span>🏠 Beranda Event</span>
                    </Link>
                </div>
            </header>

            <!-- Page Content Wrapper: p-8 (32px padding) -->
            <main class="flex-1 p-6 sm:p-8 max-w-[1400px] w-full mx-auto">
                <!-- Flash Alert Messages if any -->
                <div v-if="$page.props.flash?.success" class="mb-6 p-4 rounded-[16px] bg-[#DAEBE3] text-[#1E4D38] border border-[#DAEBE3] font-medium text-sm flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2">
                        <span>✨</span>
                        <span>{{ $page.props.flash.success }}</span>
                    </div>
                    <button @click="$page.props.flash.success = null" class="text-[#1E4D38]/70 hover:text-[#1E4D38]">✕</button>
                </div>

                <div v-if="$page.props.flash?.error" class="mb-6 p-4 rounded-[16px] bg-[#FADBD8] text-[#900C3F] border border-[#F5B7B1] font-medium text-sm flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2">
                        <span>⚠️</span>
                        <span>{{ $page.props.flash.error }}</span>
                    </div>
                    <button @click="$page.props.flash.error = null" class="text-[#900C3F]/70 hover:text-[#900C3F]">✕</button>
                </div>

                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';

const props = defineProps({
    title: {
        type: String,
        default: 'Dashboard',
    },
    subtitle: {
        type: String,
        default: '',
    },
    roleTitle: {
        type: String,
        default: 'Portal',
    },
});

const mobileOpen = ref(false);
const page = usePage();
const authUser = computed(() => page.props.auth?.user);

const userInitial = computed(() => {
    return authUser.value?.name ? authUser.value.name.charAt(0).toUpperCase() : 'U';
});

const logout = () => {
    router.post('/logout');
};
</script>
