<template>
  <div class="min-h-screen bg-daebak-cream font-sans text-daebak-charcoal flex flex-col">
    <!-- Navbar -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/80 border-b border-daebak-sage/30 px-6 py-4">
      <div class="max-w-7xl mx-auto flex items-center justify-between">
        <a href="/dashboard" class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-daebak-blue to-daebak-coral flex items-center justify-center text-white font-heading text-xl shadow-md">
            D
          </div>
          <span class="font-heading text-2xl text-daebak-charcoal">Daebak.Tix</span>
        </a>

        <!-- Nav Links -->
        <nav class="hidden md:flex items-center gap-8 text-xs font-semibold">
          <a href="/dashboard" :class="isActive('/dashboard') ? 'text-daebak-blue font-bold border-b-2 border-daebak-blue pb-1' : 'hover:text-daebak-blue'">
            🏠 Dashboard
          </a>
          <a href="/tickets" :class="isActive('/tickets') ? 'text-daebak-blue font-bold border-b-2 border-daebak-blue pb-1' : 'hover:text-daebak-blue'">
            🎫 Cari Tiket
          </a>
          <a href="/my-tickets" :class="isActive('/my-tickets') ? 'text-daebak-blue font-bold border-b-2 border-daebak-blue pb-1' : 'hover:text-daebak-blue'">
            📲 Tiket Digital / QR
          </a>
          <a href="/orders" :class="isActive('/orders') ? 'text-daebak-blue font-bold border-b-2 border-daebak-blue pb-1' : 'hover:text-daebak-blue'">
            📦 Orders Saya
          </a>
          <a href="/wishlist" :class="isActive('/wishlist') ? 'text-daebak-blue font-bold border-b-2 border-daebak-blue pb-1' : 'hover:text-daebak-blue'">
            ❤️ Wishlist
          </a>
          <a href="/loyalty" :class="isActive('/loyalty') ? 'text-daebak-coral font-bold border-b-2 border-daebak-coral pb-1' : 'hover:text-daebak-coral'">
            ⭐ Loyalty Points ({{ $page.props.auth.user?.loyalty_points || 0 }} Pts)
          </a>
        </nav>

        <!-- User Profile Dropdown / Logout -->
        <div class="flex items-center gap-3">
          <a href="/profile" class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white border border-daebak-sage/40 text-xs font-semibold hover:bg-slate-50">
            <span>👤 {{ $page.props.auth.user?.name }}</span>
          </a>
          <button @click="logout" class="text-xs font-semibold text-rose-600 hover:underline">
            Logout
          </button>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto w-full p-6 md:p-8 flex-1">
      <div v-if="$page.props.flash?.success" class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold shadow-sm">
        ✅ {{ $page.props.flash.success }}
      </div>
      <slot></slot>
    </main>
  </div>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';

const page = usePage();

const isActive = (path) => {
  return page.url === path || page.url.startsWith(path + '/');
};

const logout = () => {
  router.post('/logout');
};
</script>
