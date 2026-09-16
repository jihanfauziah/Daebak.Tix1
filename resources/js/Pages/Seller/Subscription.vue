<template>
  <Layout title="Paket Langganan & Model Akun Seller" :profile="profile">
    <div class="space-y-8">
      <!-- Current Plan Status Card -->
      <div class="card-daebak p-6 card-warm-gradient">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
          <div>
            <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Paket Aktif Toko Anda</span>
            <h2 class="font-heading text-2xl text-daebak-charcoal mt-1">
              {{ formatPackageName(profile?.subscription_type) }}
            </h2>
            <p class="text-xs text-daebak-charcoal/80 mt-1">
              Kadaluarsa: {{ profile?.subscription_expires_at ? new Date(profile.subscription_expires_at).toLocaleDateString('id-ID') : 'Tanpa Batas Waktu' }}
            </p>
          </div>
          <span class="px-4 py-2 rounded-full bg-white/80 font-bold text-xs text-daebak-charcoal shadow-sm">
            Status: Active ⚡
          </span>
        </div>
      </div>

      <!-- Plan Options -->
      <div class="grid lg:grid-cols-3 gap-8">
        <!-- Option B: Akun Free (Per-Event) -->
        <div class="card-daebak p-8 bg-white border border-daebak-sage/40 flex flex-col justify-between">
          <div class="space-y-4">
            <span class="px-3 py-1 rounded-full bg-slate-100 text-daebak-charcoal text-[11px] font-bold">OPSI B — AKUN FREE</span>
            <h3 class="font-heading text-xl text-daebak-charcoal">Bayar Per-Event</h3>
            <p class="text-xs text-daebak-charcoal/70">Cocok untuk promotor yang hanya mengadakan event sesekali.</p>
            
            <div class="py-4 border-y border-daebak-sage/30 space-y-2 text-xs">
              <p class="font-bold text-daebak-charcoal">• Durasi Awal: 7 Hari atau 12 Hari</p>
              <p class="font-bold text-daebak-charcoal">• Opsi Perpanjang: +5 Hari / +7 Hari (Memenuhi 1 siklus 15 hari)</p>
              <p class="text-rose-600 font-semibold">• Event otomatis nonaktif jika tidak diperpanjang</p>
            </div>
          </div>

          <button @click="selectPackage('free_per_event')" class="w-full btn-daebak-dark text-xs py-3 mt-6">
            Pilih Model Per-Event
          </button>
        </div>

        <!-- Option A: Paket 1 Bulan -->
        <div class="card-daebak p-8 bg-white border-2 border-daebak-blue flex flex-col justify-between relative overflow-hidden">
          <div class="space-y-4">
            <span class="px-3 py-1 rounded-full bg-daebak-mint text-daebak-charcoal text-[11px] font-bold">OPSI A — AKUN BERBAYAR</span>
            <h3 class="font-heading text-xl text-daebak-charcoal">Paket 1 Bulan</h3>
            <div class="font-heading text-3xl text-daebak-charcoal">
              Rp 499.000 <span class="text-xs font-sans text-daebak-charcoal/60">/ bulan</span>
            </div>
            
            <ul class="space-y-2 text-xs text-daebak-charcoal/80 pt-2">
              <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Buat event sebanyak yang dibutuhkan</li>
              <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Tanpa perlu perpanjang per-event</li>
              <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Akses staf PWA scanner unlimited</li>
            </ul>
          </div>

          <button @click="selectPackage('paid_1m')" class="w-full btn-daebak-primary text-xs py-3 mt-6 shadow-md">
            Beli Paket 1 Bulan
          </button>
        </div>

        <!-- Option A: Paket 3 Bulan -->
        <div class="card-daebak p-8 bg-white border-2 border-daebak-coral flex flex-col justify-between relative overflow-hidden">
          <div class="absolute -top-3 -right-3 bg-daebak-coral text-white text-[10px] font-bold px-4 py-2 rounded-bl-2xl">HEMAT 15%</div>
          <div class="space-y-4">
            <span class="px-3 py-1 rounded-full bg-daebak-cream text-daebak-charcoal text-[11px] font-bold">OPSI A — BEST VALUE</span>
            <h3 class="font-heading text-xl text-daebak-charcoal">Paket 3 Bulan</h3>
            <div class="font-heading text-3xl text-daebak-charcoal">
              Rp 1.299.000 <span class="text-xs font-sans text-daebak-charcoal/60">/ 3 bulan</span>
            </div>
            
            <ul class="space-y-2 text-xs text-daebak-charcoal/80 pt-2">
              <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Masa aktif langganan 90 hari penuh</li>
              <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Unlimited event creation</li>
              <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Prioritas dukungan admin</li>
            </ul>
          </div>

          <button @click="selectPackage('paid_3m')" class="w-full btn-daebak-secondary text-xs py-3 mt-6 shadow-md">
            Beli Paket 3 Bulan
          </button>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import Layout from './Layout.vue';

defineProps({
  profile: Object,
  history: Array,
});

const formatPackageName = (type) => {
  if (type === 'paid_1m') return 'Akun Berbayar — Paket 1 Bulan';
  if (type === 'paid_3m') return 'Akun Berbayar — Paket 3 Bulan';
  if (type === 'free') return 'Akun Free — Fitur Per-Event';
  return 'Belum Memilih Paket';
};

const selectPackage = (pkg) => {
  if (confirm(`Konfirmasi pembelian/pemilihan paket ${pkg}?`)) {
    router.post('/seller/subscription/purchase', { package: pkg });
  }
};
</script>
