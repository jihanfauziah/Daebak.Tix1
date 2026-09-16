<template>
  <Layout>
    <div class="space-y-8">
      <!-- Welcome Hero Banner -->
      <div class="card-daebak p-8 card-warm-gradient relative overflow-hidden">
        <div class="relative z-10 space-y-3 max-w-xl">
          <span class="px-3 py-1 rounded-full bg-white/80 font-bold text-xs text-daebak-charcoal">
            Selamat Datang, {{ user.name }}! 👋
          </span>
          <h1 class="font-heading text-3xl sm:text-4xl text-daebak-charcoal leading-tight">
            Berburu Tiket Konser & Fanmeeting K-Pop Impianmu
          </h1>
          <p class="text-xs sm:text-sm text-daebak-charcoal/80">
            Dapatkan tiket digital dengan QR Code resmi dari promotor terverifikasi.
          </p>
          <div class="pt-2 flex gap-3">
            <a href="/tickets" class="btn-daebak-dark text-xs py-3 px-6 shadow-md">
              Jelajahi Katalog Tiket 🎟️
            </a>
            <a href="/my-tickets" class="btn-daebak-primary text-xs py-3 px-6 shadow-md">
              Lihat Tiket Saya 📲
            </a>
          </div>
        </div>
      </div>

      <!-- Buyer Widgets Stats -->
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="card-daebak p-6 bg-white">
          <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Tiket Digital Milikmu</span>
          <p class="font-heading text-3xl text-daebak-blue mt-2">{{ stats.myTickets }}</p>
          <a href="/my-tickets" class="text-[11px] text-daebak-blue font-semibold hover:underline mt-1 block">Tampilkan QR Code ➔</a>
        </div>

        <div class="card-daebak p-6 bg-white">
          <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Riwayat Orders</span>
          <p class="font-heading text-3xl text-daebak-charcoal mt-2">{{ stats.myOrders }}</p>
          <a href="/orders" class="text-[11px] text-daebak-charcoal/60 font-semibold hover:underline mt-1 block">Lihat Semua ➔</a>
        </div>

        <div class="card-daebak p-6 bg-white">
          <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Event di Wishlist</span>
          <p class="font-heading text-3xl text-rose-500 mt-2">{{ stats.wishlists }}</p>
          <a href="/wishlist" class="text-[11px] text-rose-500 font-semibold hover:underline mt-1 block">Lihat Wishlist ➔</a>
        </div>

        <div class="card-daebak p-6 bg-white border border-daebak-coral/40">
          <span class="text-xs font-bold text-daebak-charcoal/70 uppercase">Loyalty Reward Points</span>
          <p class="font-heading text-3xl text-daebak-coral mt-2">⭐ {{ stats.loyaltyPoints }}</p>
          <a href="/loyalty" class="text-[11px] text-daebak-coral font-semibold hover:underline mt-1 block">Tukarkan Reward ➔</a>
        </div>
      </div>

      <!-- Featured K-Events Grid -->
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <h2 class="font-heading text-2xl text-daebak-charcoal">Event Korea Terpopuler Saat Ini</h2>
          <a href="/tickets" class="text-xs font-semibold text-daebak-blue hover:underline">Lihat Semua Tiket ➔</a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="event in featuredEvents" :key="event.id" class="card-daebak p-5 bg-white flex flex-col justify-between hover:border-daebak-blue">
            <div class="space-y-3">
              <div class="relative h-44 rounded-2xl overflow-hidden bg-slate-100">
                <img :src="event.banner_image" :alt="event.title" class="w-full h-full object-cover" />
                <span class="absolute top-3 right-3 bg-daebak-coral text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase shadow">
                  {{ event.category }}
                </span>
              </div>

              <div>
                <span class="text-[10px] font-bold text-daebak-blue uppercase">
                  Toko: {{ event.seller?.seller_profile?.store_name || 'Promotor Resmi' }}
                </span>
                <h3 class="font-heading text-base text-daebak-charcoal mt-1 line-clamp-1">{{ event.title }}</h3>
                <p class="text-xs text-daebak-charcoal/70 mt-1">📍 {{ event.location }}</p>
              </div>
            </div>

            <div class="pt-4 border-t border-daebak-sage/20 mt-4 flex items-center justify-between">
              <div>
                <span class="text-[10px] text-daebak-charcoal/60">Mulai dari</span>
                <p class="font-bold text-daebak-charcoal text-sm">
                  Rp {{ Number(event.categories?.[0]?.price || 0).toLocaleString('id-ID') }}
                </p>
              </div>
              <a :href="`/tickets/${event.slug}`" class="btn-daebak-primary text-xs py-2 px-4">
                Beli Tiket ➔
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

defineProps({
  user: Object,
  stats: Object,
  featuredEvents: Array,
  myRecentTickets: Array,
});
</script>
