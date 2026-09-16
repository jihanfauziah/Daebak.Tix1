<template>
  <Layout title="Wishlist Event Saya" subtitle="Daftar konser dan fanmeeting yang Anda simpan untuk dibeli nanti.">
    <div class="space-y-6">
      <div v-if="wishlists.length === 0">
        <Card padding-class="p-12" custom-class="text-center space-y-3">
          <span class="text-4xl block">❤️</span>
          <h3 class="font-heading text-xl text-[#657166]">Belum Ada Event di Wishlist</h3>
          <p class="text-xs text-[#657166]/70 max-w-sm mx-auto">
            Jelajahi konser & fanmeeting K-Pop dan klik tombol wishlist untuk menyimpan acara favoritmu.
          </p>
          <div class="pt-2">
            <PrimaryButton href="/tickets" custom-class="text-xs px-5 py-2.5">
              Jelajahi Event ➔
            </PrimaryButton>
          </div>
        </Card>
      </div>

      <div v-else class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <Card
          v-for="w in wishlists"
          :key="w.id"
          hoverable
          padding-class="p-5"
          custom-class="flex flex-col justify-between"
        >
          <div class="space-y-3">
            <div class="relative h-40 rounded-[16px] overflow-hidden bg-[#DAEBE3]/40">
              <img :src="w.event?.banner_image" :alt="w.event?.title" class="w-full h-full object-cover" />
            </div>
            <div>
              <h3 class="font-heading text-base text-[#657166] line-clamp-1">{{ w.event?.title }}</h3>
              <p class="text-xs text-[#657166]/70 mt-0.5">📍 {{ w.event?.location }}</p>
            </div>
          </div>

          <div class="pt-4 border-t border-[#CFD6C4]/30 mt-4 flex items-center justify-between">
            <PrimaryButton :href="`/tickets/${w.event?.slug}`" custom-class="text-xs py-2 px-4 w-full">
              Beli Tiket Sekarang ➔
            </PrimaryButton>
          </div>
        </Card>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
  wishlists: {
    type: Array,
    default: () => []
  }
});
</script>
