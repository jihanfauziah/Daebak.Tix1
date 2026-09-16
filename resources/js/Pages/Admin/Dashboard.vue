<template>
  <Layout title="Admin Platform Overview">
    <div class="space-y-8">
      <!-- Stat Widgets Grid -->
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <StatCard
          label="Total Penjualan Tiket"
          :value="`Rp ${stats.totalSales.toLocaleString('id-ID')}`"
          color="coral"
          subtext="Bruto Transaksi Berhasil"
        >
          <template #icon>💰</template>
        </StatCard>

        <StatCard
          label="Total Transaksi"
          :value="stats.totalOrders"
          color="blue"
          subtext="Seluruh Pesanan Masuk"
        >
          <template #icon>📦</template>
        </StatCard>

        <StatCard
          label="Total Pembeli"
          :value="stats.totalBuyers"
          color="mint"
          subtext="Pengguna Terverifikasi"
        >
          <template #icon>👥</template>
        </StatCard>

        <StatCard
          label="Toko Promotor"
          :value="stats.totalSellers"
          color="sage"
          subtext="Mitra Terdaftar"
        >
          <template #icon>🏪</template>
        </StatCard>
      </div>

      <!-- Secondary Widgets & Charts -->
      <div class="grid lg:grid-cols-3 gap-8">
        <!-- Ticket Usage Summary -->
        <Card padding-class="p-6">
          <h3 class="font-heading text-xl mb-4 text-[#657166]">Status Tiket Digital</h3>
          <div class="flex items-center justify-center py-6">
            <div class="relative w-40 h-40 rounded-full border-8 border-[#DAEBE3] flex items-center justify-center bg-[#FDE8D3]/30 shadow-inner">
              <div class="text-center">
                <span class="font-heading text-3xl text-[#657166]">{{ stats.activeTickets + stats.usedTickets }}</span>
                <span class="block text-[10px] text-[#657166]/70 font-semibold uppercase tracking-wider">Total Tiket</span>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4 text-center border-t border-[#CFD6C4]/40 pt-4 text-xs">
            <div>
              <span class="block text-[#1E4D38] font-bold text-lg font-sans">{{ stats.activeTickets }}</span>
              <span class="text-[#657166]/70">Aktif (Valid)</span>
            </div>
            <div>
              <span class="block text-[#657166] font-bold text-lg font-sans">{{ stats.usedTickets }}</span>
              <span class="text-[#657166]/70">Sudah Discan</span>
            </div>
          </div>
        </Card>

        <!-- Quick Seller Verification Table -->
        <div class="lg:col-span-2">
          <Card padding-class="p-6">
            <div class="flex items-center justify-between mb-4 border-b border-[#CFD6C4]/40 pb-3">
              <h3 class="font-heading text-xl text-[#657166]">Toko Promotor Terbaru</h3>
              <Link href="/admin/sellers" class="text-xs font-semibold text-[#2D3A30] hover:underline">
                Lihat Semua ➔
              </Link>
            </div>
            
            <div class="overflow-x-auto">
              <table class="w-full text-left text-xs">
                <thead>
                  <tr class="border-b border-[#CFD6C4]/50 text-[#657166]/70 uppercase">
                    <th class="py-2.5 px-3 font-bold">Toko Promotor</th>
                    <th class="py-2.5 px-3 font-bold">Email</th>
                    <th class="py-2.5 px-3 font-bold">Kode Akun</th>
                    <th class="py-2.5 px-3 font-bold">Status</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-[#CFD6C4]/30">
                  <tr v-for="seller in recentSellers" :key="seller.id">
                    <td class="py-3 px-3 font-semibold text-sm text-[#2D3A30]">{{ seller.store_name }}</td>
                    <td class="py-3 px-3 text-[#657166]">{{ seller.store_email }}</td>
                    <td class="py-3 px-3">
                      <span class="font-mono bg-[#DAEBE3] px-2 py-0.5 rounded-[8px] text-xs font-bold text-[#1E4D38]">
                        {{ seller.account_code }}
                      </span>
                    </td>
                    <td class="py-3 px-3">
                      <Badge :variant="seller.status === 'approved' ? 'success' : 'warning'" :dot="true">
                        {{ seller.status }}
                      </Badge>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </Card>
        </div>
      </div>

      <!-- Activity Log Preview -->
      <Card padding-class="p-6">
        <div class="flex items-center justify-between mb-4 border-b border-[#CFD6C4]/40 pb-3">
          <h3 class="font-heading text-xl text-[#657166]">Log Audit Sistem Terkini</h3>
          <Link href="/admin/logs" class="text-xs font-semibold text-[#2D3A30] hover:underline">
            Lihat Log Lengkap ➔
          </Link>
        </div>
        <div class="space-y-3">
          <div v-for="log in recentLogs" :key="log.id" class="flex items-center justify-between text-xs py-2 border-b border-[#CFD6C4]/20">
            <div class="flex items-center gap-3">
              <span class="w-2 h-2 rounded-full bg-[#99CDD8]"></span>
              <span class="font-semibold text-[#2D3A30]">{{ log.user?.name || 'Sistem' }}</span>
              <span class="text-[#657166]/70">({{ log.role || 'system' }})</span>
              <span class="text-[#657166]">— {{ log.description }}</span>
            </div>
            <span class="text-[11px] text-[#657166]/60">{{ new Date(log.created_at).toLocaleString('id-ID') }}</span>
          </div>
        </div>
      </Card>
    </div>
  </Layout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import StatCard from '@/Components/StatCard.vue';
import Badge from '@/Components/Badge.vue';

defineProps({
  stats: Object,
  recentSellers: Array,
  recentOrders: Array,
  recentLogs: Array,
});
</script>
