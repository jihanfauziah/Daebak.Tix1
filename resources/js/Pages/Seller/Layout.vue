<template>
  <div class="min-h-screen bg-daebak-cream font-sans text-daebak-charcoal flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white/90 backdrop-blur-md border-r border-daebak-sage/30 p-6 flex flex-col justify-between hidden md:flex min-h-screen sticky top-0 h-screen">
      <div class="space-y-8">
        <!-- Store Brand Header -->
        <a href="/" class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-daebak-coral to-daebak-blue flex items-center justify-center text-white font-heading text-xl shadow-md">
            S
          </div>
          <div class="min-w-0">
            <span class="font-heading text-base text-daebak-charcoal truncate block">{{ profile?.store_name || 'My Seller Store' }}</span>
            <span class="block text-[10px] font-bold text-daebak-coral font-mono">CODE: {{ profile?.account_code || 'SELLER' }}</span>
          </div>
        </a>

        <!-- Navigation Links -->
        <nav class="space-y-1.5 text-xs font-semibold">
          <a href="/seller/dashboard" :class="isActive('/seller/dashboard') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>📈</span> Dashboard
          </a>
          <a href="/seller/events" :class="isActive('/seller/events') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>🎟️</span> My Event
          </a>
          <a href="/seller/events/create" :class="isActive('/seller/events/create') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>➕</span> New Event
          </a>
          <a href="/seller/subscription" :class="isActive('/seller/subscription') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>👑</span> Paket Langganan
          </a>
          <a href="/seller/staff" :class="isActive('/seller/staff') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>👥</span> Buat Akun Staf (PWA)
          </a>
          <a href="/seller/orders" :class="isActive('/seller/orders') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>📦</span> Orders
          </a>
          <a href="/seller/profile" :class="isActive('/seller/profile') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>👤</span> Profil Toko
          </a>
        </nav>
      </div>

      <!-- User Info & Logout -->
      <div class="pt-4 border-t border-daebak-sage/30 space-y-3">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-full bg-daebak-blue text-daebak-charcoal font-bold text-xs flex items-center justify-center">
            SL
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-xs font-bold text-daebak-charcoal truncate">{{ $page.props.auth.user?.name }}</p>
            <p class="text-[10px] text-daebak-charcoal/60 truncate">Seller Toko</p>
          </div>
        </div>
        <button @click="logout" class="w-full text-left text-xs font-semibold text-rose-600 hover:text-rose-800 px-3 py-2 rounded-xl hover:bg-rose-50 transition-all flex items-center gap-2">
          <span>🚪</span> Logout Toko
        </button>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 min-w-0 flex flex-col">
      <!-- Topbar -->
      <header class="bg-white/80 backdrop-blur border-b border-daebak-sage/30 px-6 py-4 flex items-center justify-between sticky top-0 z-40">
        <h1 class="font-heading text-xl text-daebak-charcoal">{{ title }}</h1>
        <div class="flex items-center gap-3">
          <a href="/" target="_blank" class="text-xs px-3 py-1.5 rounded-xl border border-daebak-sage hover:bg-slate-50 font-medium">
            👁️ View Site (Preview Storefront)
          </a>
        </div>
      </header>

      <!-- Content -->
      <main class="p-6 md:p-8 flex-1 overflow-y-auto">
        <div v-if="$page.props.flash?.success" class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold shadow-sm">
          ✅ {{ $page.props.flash.success }}
        </div>
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';

defineProps({
  title: String,
  profile: Object,
});

const page = usePage();

const isActive = (path) => {
  return page.url.startsWith(path);
};

const logout = () => {
  router.post('/logout');
};
</script>
