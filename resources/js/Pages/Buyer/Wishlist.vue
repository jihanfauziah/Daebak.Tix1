<template>
  <Layout>
    <div class="space-y-6">
      <div class="card-daebak p-6 bg-white">
        <h1 class="font-heading text-2xl text-daebak-charcoal mb-2">Wishlist Event Favorit Saya</h1>
        <p class="text-xs text-daebak-charcoal/70">Daftar event Korea yang Anda simpan untuk dibeli nanti.</p>
      </div>

      <div v-if="wishlists.length === 0" class="card-daebak p-12 bg-white text-center space-y-3">
        <span class="text-4xl">❤️</span>
        <h3 class="font-heading text-lg">Belum Ada Wishlist</h3>
        <p class="text-xs text-daebak-charcoal/70">Jelajahi tiket konser & fanmeeting untuk menambah favorit Anda.</p>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="w in wishlists" :key="w.id" class="card-daebak p-5 bg-white flex flex-col justify-between">
          <div class="space-y-3">
            <div class="relative h-40 rounded-2xl overflow-hidden bg-slate-100">
              <img :src="w.event?.banner_image" :alt="w.event?.title" class="w-full h-full object-cover" />
            </div>
            <h3 class="font-heading text-base text-daebak-charcoal">{{ w.event?.title }}</h3>
            <p class="text-xs text-daebak-charcoal/70">📍 {{ w.event?.location }}</p>
          </div>

          <div class="pt-4 border-t border-daebak-sage/20 mt-4 flex items-center justify-between">
            <a :href="`/tickets/${w.event?.slug}`" class="btn-daebak-primary text-xs py-2 px-4">
              Beli Tiket ➔
            </a>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

defineProps({
  wishlists: Array
});
</script>
