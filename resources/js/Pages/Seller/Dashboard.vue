<template>
  <Layout title="Dashboard Promotor Overview" :profile="profile">
    <div class="space-y-8">
      <!-- Stat Widgets -->
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <StatCard
          label="Total Pendapatan Tiket"
          :value="`Rp ${stats.totalSales.toLocaleString('id-ID')}`"
          color="coral"
          subtext="Hasil Penjualan Terverifikasi"
        >
          <template #icon>💰</template>
        </StatCard>

        <StatCard
          label="Total Orders Masuk"
          :value="stats.totalOrders"
          color="blue"
          subtext="Transaksi Pembeli"
        >
          <template #icon>📦</template>
        </StatCard>

        <StatCard
          label="Event Aktif Dijual"
          :value="stats.activeEvents"
          color="mint"
          subtext="Live di Katalog"
        >
          <template #icon>🎟️</template>
        </StatCard>

        <StatCard
          label="Petugas Staf Scan"
          :value="stats.totalStaff"
          color="sage"
          subtext="Akun Staf PWA Kamera"
        >
          <template #icon>👥</template>
        </StatCard>
      </div>

      <!-- Quick Actions Banner -->
      <Card padding-class="p-6" custom-class="border-l-4 border-l-[#F3C3B2] bg-gradient-to-r from-white via-white to-[#FDE8D3]/30">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
          <div>
            <h3 class="font-heading text-xl text-[#657166]">Siap Membuka Penjualan Event K-Pop Baru?</h3>
            <p class="text-xs text-[#657166]/70 mt-1">Gunakan durasi awal (7 hari / 12 hari) atau aktifkan langganan toko bulanan.</p>
          </div>
          <PrimaryButton href="/seller/events/create" custom-class="text-xs px-6 py-3 shadow-md">
            + Buat Event Baru 🚀
          </PrimaryButton>
        </div>
      </Card>

      <!-- My Events Grid -->
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <h3 class="font-heading text-2xl text-[#657166]">Event Milik Toko Anda</h3>
          <Link href="/seller/events" class="text-xs font-semibold text-[#2D3A30] hover:underline">
            Kelola Semua Event ➔
          </Link>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <Card
            v-for="event in myEvents"
            :key="event.id"
            padding-class="p-5"
            custom-class="flex flex-col justify-between"
          >
            <div class="space-y-3">
              <div class="relative h-44 rounded-[16px] overflow-hidden bg-[#DAEBE3]/40">
                <img :src="event.banner_image" :alt="event.title" class="w-full h-full object-cover" />
                <div class="absolute top-2 right-2">
                  <Badge variant="coral">{{ event.category }}</Badge>
                </div>
              </div>

              <div>
                <h4 class="font-heading text-base text-[#657166] line-clamp-1">{{ event.title }}</h4>
                <p class="text-xs text-[#657166]/70 mt-1">📍 {{ event.location }}</p>
              </div>
            </div>

            <div class="mt-4 pt-3 border-t border-[#CFD6C4]/30 flex items-center justify-between text-xs">
              <Badge :variant="event.status === 'active' ? 'success' : 'danger'" :dot="true">
                {{ event.status === 'active' ? 'Aktif Dijual' : 'Nonaktif' }}
              </Badge>
              <span class="text-[11px] text-[#657166]/70">
                Exp: {{ event.expires_at ? new Date(event.expires_at).toLocaleDateString('id-ID') : '-' }}
              </span>
            </div>
          </Card>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import StatCard from '@/Components/StatCard.vue';
import Badge from '@/Components/Badge.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
  profile: Object,
  stats: Object,
  myEvents: Array,
  staffAccounts: Array,
});
</script>
