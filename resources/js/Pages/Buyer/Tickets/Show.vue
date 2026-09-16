<template>
  <Layout :title="event?.title || 'Detail Event'" subtitle="Pilih kategori tiket dan lanjutkan pembayaran resmi.">
    <div class="space-y-8 max-w-5xl mx-auto">
      <!-- Banner -->
      <div class="relative h-64 sm:h-80 rounded-[24px] overflow-hidden shadow-[0_4px_20px_rgba(101,113,102,0.12)] border border-[#CFD6C4]/60 bg-[#657166]">
        <img :src="event.banner_image" :alt="event.title" class="w-full h-full object-cover opacity-90" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex items-end p-6 sm:p-8">
          <div class="text-white space-y-2">
            <Badge variant="coral">{{ event.category }}</Badge>
            <h1 class="font-heading text-2xl sm:text-4xl text-white leading-tight">{{ event.title }}</h1>
            <p class="text-xs sm:text-sm text-white/90">📍 {{ event.location }} • 📅 {{ event.event_date ? new Date(event.event_date).toLocaleDateString('id-ID') : '-' }}</p>
          </div>
        </div>
      </div>

      <!-- Description & Ticket Selection Grid -->
      <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
          <Card padding-class="p-6">
            <h2 class="font-heading text-xl text-[#657166] border-b border-[#CFD6C4]/40 pb-3 mb-4">Deskripsi Event</h2>
            <p class="text-sm text-[#657166]/85 whitespace-pre-line leading-relaxed">
              {{ event.description }}
            </p>

            <div class="pt-6 border-t border-[#CFD6C4]/40 mt-6">
              <h3 class="font-heading text-base text-[#657166] mb-3">Informasi Promotor Resmi</h3>
              <div class="flex items-center justify-between text-xs p-4 rounded-[16px] bg-[#DAEBE3]/40 border border-[#CFD6C4]/50">
                <div>
                  <span class="font-bold text-sm text-[#2D3A30] block">{{ event.seller?.seller_profile?.store_name || 'Promotor Resmi' }}</span>
                  <span class="text-[11px] text-[#657166]/70">Promotor Resmi Terverifikasi Admin Daebak.Tix</span>
                </div>
                <button
                  type="button"
                  @click="toggleWishlist"
                  class="px-3.5 py-2 rounded-[12px] border border-[#F3C3B2] bg-white text-[#8C4E37] font-semibold text-xs hover:bg-[#FDE8D3]/30 transition-colors"
                >
                  {{ isWishlisted ? '❤️ Tersimpan di Wishlist' : '🤍 Tambah ke Wishlist' }}
                </button>
              </div>
            </div>
          </Card>
        </div>

        <!-- Ticket Category Purchasing Form -->
        <div>
          <Card padding-class="p-6" custom-class="space-y-5 sticky top-24">
            <h3 class="font-heading text-xl text-[#657166]">Pilih Kategori Tiket</h3>

            <form @submit.prevent="checkout" class="space-y-4">
              <div
                v-for="cat in event.categories"
                :key="cat.id"
                class="p-4 rounded-[16px] border-[1.5px] cursor-pointer transition-all"
                :class="selectedCategoryId === cat.id ? 'border-[#99CDD8] bg-[#DAEBE3]/30 ring-2 ring-[#99CDD8]/40 shadow-xs' : 'border-[#CFD6C4]/60 hover:border-[#99CDD8]/60'"
                @click="selectedCategoryId = cat.id"
              >
                <div class="flex items-center justify-between mb-1">
                  <span class="font-bold text-sm text-[#2D3A30]">{{ cat.name }}</span>
                  <input
                    type="radio"
                    :value="cat.id"
                    v-model="selectedCategoryId"
                    class="text-[#99CDD8] focus:ring-[#99CDD8]"
                  />
                </div>
                <p class="font-bold text-lg text-[#657166] font-sans">Rp {{ Number(cat.price).toLocaleString('id-ID') }}</p>
                <span class="text-[11px] text-[#657166]/70 block mt-1">Sisa Kuota: {{ cat.available_quota }} Tiket</span>
              </div>

              <div>
                <label class="block text-xs font-semibold text-[#657166] mb-1.5 font-sans">Jumlah Tiket (Maks. 4 Tiket per Akun NIK)</label>
                <select
                  v-model="quantity"
                  class="w-full bg-white text-[#657166] border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans focus:outline-none focus:border-[#99CDD8]"
                >
                  <option :value="1">1 Tiket</option>
                  <option :value="2">2 Tiket</option>
                  <option :value="3">3 Tiket</option>
                  <option :value="4">4 Tiket</option>
                </select>
              </div>

              <div class="pt-2">
                <PrimaryButton
                  type="submit"
                  :disabled="!selectedCategoryId"
                  custom-class="w-full py-3.5 text-sm font-semibold shadow-md"
                >
                  Lanjut ke Pembayaran 💳
                </PrimaryButton>
              </div>
            </form>
          </Card>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Layout from '../Layout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
  event: Object,
  isWishlisted: Boolean,
});

const selectedCategoryId = ref(props.event?.categories?.[0]?.id || null);
const quantity = ref(1);

const checkout = () => {
  router.post('/checkout', {
    event_id: props.event.id,
    category_id: selectedCategoryId.value,
    quantity: quantity.value,
  });
};

const toggleWishlist = () => {
  router.post('/wishlist/toggle', { event_id: props.event.id });
};
</script>
