<template>
  <Layout>
    <div class="space-y-8">
      <!-- Welcome Hero Banner -->
      <div class="card-daebak p-8 relative overflow-hidden bg-gradient-to-r from-[#FDE8D3] via-[#F3C3B2]/30 to-[#DAEBE3] border border-[#CFD6C4]/60">
        <div class="relative z-10 space-y-3 max-w-xl">
          <Badge variant="mint">Selamat Datang, {{ user?.name }}! 👋</Badge>
          <h1 class="font-heading text-3xl sm:text-4xl text-[#657166] leading-tight">
            Berburu Tiket Konser & Fanmeeting K-Pop Impianmu
          </h1>
          <p class="text-xs sm:text-sm text-[#657166]/85">
            Dapatkan tiket digital ber-QR Code resmi dari promotor terverifikasi di Indonesia.
          </p>
          <div class="pt-2 flex flex-wrap gap-3">
            <PrimaryButton href="/tickets" custom-class="text-xs py-3 px-6 shadow-md">
              Jelajahi Katalog Tiket 🎟️
            </PrimaryButton>
            <SecondaryButton href="/my-tickets" variant="mint" custom-class="text-xs py-3 px-6 shadow-md">
              Lihat Tiket Saya 📲
            </SecondaryButton>
          </div>
        </div>
      </div>

      <!-- Buyer Widgets Stats using StatCard -->
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <StatCard
          label="Tiket Digital Saya"
          :value="stats.myTickets"
          color="blue"
          subtext="Tampilkan QR Code"
        >
          <template #icon>🎫</template>
        </StatCard>

        <StatCard
          label="Riwayat Orders"
          :value="stats.myOrders"
          color="sage"
          subtext="Total transaksi"
        >
          <template #icon>📦</template>
        </StatCard>

        <StatCard
          label="Event di Wishlist"
          :value="stats.wishlists"
          color="coral"
          subtext="Favorit tersimpan"
        >
          <template #icon>❤️</template>
        </StatCard>

        <StatCard
          label="Loyalty Reward"
          :value="`${stats.loyaltyPoints} Pts`"
          color="cream"
          subtext="Tukarkan reward"
        >
          <template #icon>⭐</template>
        </StatCard>
      </div>

      <!-- Featured K-Events Grid -->
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="font-heading text-2xl text-[#657166]">Event Korea Terpopuler</h2>
            <p class="text-xs text-[#657166]/70">Pilihan konser & fanmeeting terlaris bulan ini</p>
          </div>
          <Link href="/tickets" class="text-xs font-semibold text-[#2D3A30] hover:underline">
            Lihat Semua Tiket ➔
          </Link>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <Card
            v-for="event in featuredEvents"
            :key="event.id"
            hoverable
            padding-class="p-5"
            custom-class="flex flex-col justify-between"
          >
            <div class="space-y-3">
              <div class="relative h-44 rounded-[16px] overflow-hidden bg-[#DAEBE3]/50">
                <img :src="event.banner_image" :alt="event.title" class="w-full h-full object-cover" />
                <div class="absolute top-3 right-3">
                  <Badge variant="coral">{{ event.category }}</Badge>
                </div>
              </div>

              <div>
                <span class="text-[10px] font-bold text-[#8C4E37] uppercase tracking-wider">
                  Promotor: {{ event.seller?.seller_profile?.store_name || 'Promotor Resmi' }}
                </span>
                <h3 class="font-heading text-lg text-[#657166] mt-1 line-clamp-1">{{ event.title }}</h3>
                <p class="text-xs text-[#657166]/70 mt-0.5">📍 {{ event.location }}</p>
              </div>
            </div>

            <div class="pt-4 border-t border-[#CFD6C4]/30 mt-4 flex items-center justify-between">
              <div>
                <span class="text-[10px] text-[#657166]/60">Mulai dari</span>
                <p class="font-bold text-[#657166] text-base font-sans">
                  Rp {{ Number(event.categories?.[0]?.price || 0).toLocaleString('id-ID') }}
                </p>
              </div>
              <PrimaryButton :href="`/tickets/${event.slug}`" custom-class="text-xs py-2 px-4">
                Beli Tiket ➔
              </PrimaryButton>
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
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
  user: Object,
  stats: Object,
  featuredEvents: Array,
  myRecentTickets: Array,
});
</script>
