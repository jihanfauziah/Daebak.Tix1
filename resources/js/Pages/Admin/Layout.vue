<template>
  <div class="min-h-screen bg-daebak-cream font-sans text-daebak-charcoal flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white/90 backdrop-blur-md border-r border-daebak-sage/30 p-6 flex flex-col justify-between hidden md:flex min-h-screen sticky top-0 h-screen">
      <div class="space-y-8">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-daebak-blue to-daebak-coral flex items-center justify-center text-white font-heading text-xl shadow-md">
            D
          </div>
          <div>
            <span class="font-heading text-xl text-daebak-charcoal">Daebak.Tix</span>
            <span class="block text-[10px] uppercase tracking-wider font-bold text-daebak-coral">Admin Console</span>
          </div>
        </a>

        <!-- Navigation Links -->
        <nav class="space-y-1.5 text-xs font-semibold">
          <a href="/admin/dashboard" :class="isActive('/admin/dashboard') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>📊</span> Dashboard
          </a>
          <a href="/admin/sellers" :class="isActive('/admin/sellers') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>🏪</span> Manajemen Penjual
          </a>
          <a href="/admin/buyers" :class="isActive('/admin/buyers') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>👥</span> Manajemen Pembeli
          </a>
          <a href="/admin/events" :class="isActive('/admin/events') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>🎟️</span> Semua Event & Tiket
          </a>
          <a href="/admin/transactions" :class="isActive('/admin/transactions') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>💳</span> Transaksi Pembelian
          </a>
          <a href="/admin/logs" :class="isActive('/admin/logs') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>📜</span> Activity Logs
          </a>
          <a href="/admin/reports" :class="isActive('/admin/reports') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>📈</span> Export Laporan
          </a>
          <a href="/admin/settings" :class="isActive('/admin/settings') ? 'bg-daebak-mint text-daebak-charcoal shadow-sm' : 'hover:bg-slate-50 text-daebak-charcoal/70'" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
            <span>⚙️</span> Pengaturan Platform
          </a>
        </nav>
      </div>

      <!-- User Profile & Logout -->
      <div class="pt-4 border-t border-daebak-sage/30 space-y-3">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-full bg-daebak-coral text-white font-bold text-xs flex items-center justify-center">
            AD
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-xs font-bold text-daebak-charcoal truncate">{{ $page.props.auth.user?.name || 'Administrator' }}</p>
            <p class="text-[10px] text-daebak-charcoal/60 truncate">Role: Admin</p>
          </div>
        </div>
        <button @click="logout" class="w-full text-left text-xs font-semibold text-rose-600 hover:text-rose-800 px-3 py-2 rounded-xl hover:bg-rose-50 transition-all flex items-center gap-2">
          <span>🚪</span> Logout
        </button>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 min-w-0 flex flex-col">
      <!-- Topbar -->
      <header class="bg-white/80 backdrop-blur border-b border-daebak-sage/30 px-6 py-4 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-3">
          <h1 class="font-heading text-xl text-daebak-charcoal">{{ title }}</h1>
        </div>
        <div class="flex items-center gap-4">
          <a href="/" target="_blank" class="text-xs px-3 py-1.5 rounded-xl border border-daebak-sage hover:bg-slate-50 font-medium">
            🌐 Lihat Landing Page
          </a>
        </div>
      </header>

      <!-- Page Content -->
      <main class="p-6 md:p-8 flex-1 overflow-y-auto">
        <!-- Flash Alert -->
        <div v-if="$page.props.flash?.success" class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-sm">
          <span>✅ {{ $page.props.flash.success }}</span>
        </div>
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';

defineProps({
  title: {
    type: String,
    default: 'Admin Dashboard'
  }
});

const page = usePage();

const isActive = (path) => {
  return page.url.startsWith(path);
};

const logout = () => {
  router.post('/logout');
};
</script>
