<template>
  <Layout title="Dashboard Overview — Admin Platform">
    <!-- Stat Widgets Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="card-daebak p-6 card-warm-gradient relative overflow-hidden">
        <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Total Penjualan</span>
        <p class="font-heading text-2xl sm:text-3xl text-daebak-charcoal mt-2">
          Rp {{ stats.totalSales.toLocaleString('id-ID') }}
        </p>
        <span class="text-[10px] text-daebak-charcoal/60 mt-1 block">Bruto Transaksi Berhasil</span>
      </div>

      <div class="card-daebak p-6 card-soft-gradient">
        <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Total Pesanan (Orders)</span>
        <p class="font-heading text-3xl text-daebak-charcoal mt-2">{{ stats.totalOrders }}</p>
        <span class="text-[10px] text-daebak-charcoal/60 mt-1 block">Seluruh Transaksi</span>
      </div>

      <div class="card-daebak p-6 bg-white">
        <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Akun Pembeli</span>
        <p class="font-heading text-3xl text-daebak-charcoal mt-2">{{ stats.totalBuyers }}</p>
        <span class="text-[10px] text-daebak-charcoal/60 mt-1 block">Pengguna Terdaftar</span>
      </div>

      <div class="card-daebak p-6 bg-white">
        <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Toko Penjual (Seller)</span>
        <p class="font-heading text-3xl text-daebak-coral mt-2">{{ stats.totalSellers }}</p>
        <span class="text-[10px] text-daebak-charcoal/60 mt-1 block">Mitra Terverifikasi</span>
      </div>
    </div>

    <!-- Secondary Widgets & Charts -->
    <div class="grid lg:grid-cols-3 gap-8 mb-8">
      <!-- Ticket Usage Donut Summary -->
      <div class="card-daebak p-6 bg-white">
        <h3 class="font-heading text-lg mb-4 text-daebak-charcoal">Status Tiket Digital</h3>
        <div class="flex items-center justify-center py-6">
          <div class="relative w-40 h-40 rounded-full border-8 border-daebak-mint flex items-center justify-center bg-daebak-cream/20">
            <div class="text-center">
              <span class="font-heading text-3xl text-daebak-charcoal">{{ stats.activeTickets + stats.usedTickets }}</span>
              <span class="block text-[10px] text-daebak-charcoal/60 font-semibold">Total Tiket</span>
            </div>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4 text-center border-t border-daebak-sage/30 pt-4 text-xs">
          <div>
            <span class="block text-emerald-600 font-bold text-base">{{ stats.activeTickets }}</span>
            <span class="text-daebak-charcoal/60">Aktif (Valid)</span>
          </div>
          <div>
            <span class="block text-slate-500 font-bold text-base">{{ stats.usedTickets }}</span>
            <span class="text-daebak-charcoal/60">Sudah Discan</span>
          </div>
        </div>
      </div>

      <!-- Quick Seller Verification Action -->
      <div class="lg:col-span-2 card-daebak p-6 bg-white">
        <div class="flex items-center justify-between mb-4 border-b border-daebak-sage/30 pb-3">
          <h3 class="font-heading text-lg text-daebak-charcoal">Toko Penjual Terbaru</h3>
          <a href="/admin/sellers" class="text-xs font-semibold text-daebak-blue hover:underline">Lihat Semua ➔</a>
        </div>
        
        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="border-b border-daebak-sage/30 text-daebak-charcoal/60">
                <th class="py-2.5 px-3">Toko Seller</th>
                <th class="py-2.5 px-3">Email Toko</th>
                <th class="py-2.5 px-3">Kode Akun</th>
                <th class="py-2.5 px-3">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-daebak-sage/20">
              <tr v-for="seller in recentSellers" :key="seller.id">
                <td class="py-3 px-3 font-semibold">{{ seller.store_name }}</td>
                <td class="py-3 px-3 text-daebak-charcoal/70">{{ seller.store_email }}</td>
                <td class="py-3 px-3"><span class="font-mono bg-daebak-mint/60 px-2 py-0.5 rounded text-[11px] font-bold">{{ seller.account_code }}</span></td>
                <td class="py-3 px-3">
                  <span class="px-2.5 py-1 rounded-full text-[10px] font-bold" :class="seller.status === 'approved' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'">
                    {{ seller.status }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Activity Log Preview -->
    <div class="card-daebak p-6 bg-white">
      <div class="flex items-center justify-between mb-4 border-b border-daebak-sage/30 pb-3">
        <h3 class="font-heading text-lg text-daebak-charcoal">Activity Logs Terbaru</h3>
        <a href="/admin/logs" class="text-xs font-semibold text-daebak-blue hover:underline">Lihat Log Audit Lengkap ➔</a>
      </div>
      <div class="space-y-3">
        <div v-for="log in recentLogs" :key="log.id" class="flex items-center justify-between text-xs py-2 border-b border-daebak-sage/10">
          <div class="flex items-center gap-3">
            <span class="w-2 h-2 rounded-full bg-daebak-blue"></span>
            <span class="font-semibold text-daebak-charcoal">{{ log.user?.name || 'Sistem' }}</span>
            <span class="text-daebak-charcoal/60">({{ log.role || 'system' }})</span>
            <span class="text-daebak-charcoal/80">— {{ log.description }}</span>
          </div>
          <span class="text-[10px] text-daebak-charcoal/50">{{ new Date(log.created_at).toLocaleString('id-ID') }}</span>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

defineProps({
  stats: Object,
  recentSellers: Array,
  recentOrders: Array,
  recentLogs: Array,
});
</script>
