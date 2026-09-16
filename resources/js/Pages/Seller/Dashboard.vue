<template>
  <Layout title="Seller Dashboard Overview" :profile="profile">
    <!-- Stat Widgets -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="card-daebak p-6 card-warm-gradient">
        <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Total Pendapatan Tiket</span>
        <p class="font-heading text-2xl sm:text-3xl text-daebak-charcoal mt-2">
          Rp {{ stats.totalSales.toLocaleString('id-ID') }}
        </p>
        <span class="text-[10px] text-daebak-charcoal/60 mt-1 block">Hasil Penjualan Terverifikasi</span>
      </div>

      <div class="card-daebak p-6 card-soft-gradient">
        <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Total Orders</span>
        <p class="font-heading text-3xl text-daebak-charcoal mt-2">{{ stats.totalOrders }}</p>
        <span class="text-[10px] text-daebak-charcoal/60 mt-1 block">Transaksi Masuk</span>
      </div>

      <div class="card-daebak p-6 bg-white">
        <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Event Aktif Dijual</span>
        <p class="font-heading text-3xl text-emerald-600 mt-2">{{ stats.activeEvents }}</p>
        <span class="text-[10px] text-daebak-charcoal/60 mt-1 block">Live di Katalog</span>
      </div>

      <div class="card-daebak p-6 bg-white">
        <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Petugas Staf Scan (PWA)</span>
        <p class="font-heading text-3xl text-daebak-blue mt-2">{{ stats.totalStaff }}</p>
        <span class="text-[10px] text-daebak-charcoal/60 mt-1 block">Akun Staf Lapangan</span>
      </div>
    </div>

    <!-- Quick Actions Banner -->
    <div class="card-daebak p-6 bg-white mb-8 border-l-4 border-l-daebak-coral">
      <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
          <h3 class="font-heading text-lg text-daebak-charcoal">Siap Membuat Event Korea Baru?</h3>
          <p class="text-xs text-daebak-charcoal/70">Pilih durasi per-event (7 hari / 12 hari) atau gunakan paket langganan toko bulanan.</p>
        </div>
        <a href="/seller/events/create" class="btn-daebak-primary text-xs font-semibold px-6 py-3 shadow">
          + Buat Event Baru
        </a>
      </div>
    </div>

    <!-- My Events Grid -->
    <div class="card-daebak p-6 bg-white">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-heading text-lg text-daebak-charcoal">Event Korea Milik Toko Anda</h3>
        <a href="/seller/events" class="text-xs font-semibold text-daebak-blue hover:underline">Kelola Semua ➔</a>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="event in myEvents" :key="event.id" class="card-daebak p-5 border border-daebak-sage/30">
          <div class="relative h-40 rounded-2xl overflow-hidden bg-slate-100 mb-3">
            <img :src="event.banner_image" :alt="event.title" class="w-full h-full object-cover" />
            <span class="absolute top-2 right-2 bg-daebak-coral text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
              {{ event.category }}
            </span>
          </div>

          <h4 class="font-heading text-base text-daebak-charcoal line-clamp-1">{{ event.title }}</h4>
          <p class="text-xs text-daebak-charcoal/70 mt-1">📍 {{ event.location }}</p>

          <div class="mt-4 pt-3 border-t border-daebak-sage/20 flex items-center justify-between text-xs">
            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold" :class="event.status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'">
              {{ event.status === 'active' ? 'Aktif Dijual' : 'Nonaktif / Expired' }}
            </span>
            <span class="text-[10px] text-daebak-charcoal/60">
              Expired: {{ event.expires_at ? new Date(event.expires_at).toLocaleDateString('id-ID') : '-' }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

defineProps({
  profile: Object,
  stats: Object,
  myEvents: Array,
  staffAccounts: Array,
});
</script>
