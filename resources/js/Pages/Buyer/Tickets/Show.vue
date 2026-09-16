<template>
  <Layout>
    <div class="space-y-8 max-w-4xl mx-auto">
      <!-- Banner -->
      <div class="relative h-64 sm:h-96 rounded-3xl overflow-hidden shadow-xl bg-slate-900">
        <img :src="event.banner_image" :alt="event.title" class="w-full h-full object-cover opacity-90" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex items-end p-6 sm:p-10">
          <div class="text-white space-y-2">
            <span class="bg-daebak-coral text-white text-xs font-bold px-3 py-1 rounded-full uppercase">
              {{ event.category }}
            </span>
            <h1 class="font-heading text-2xl sm:text-4xl leading-tight">{{ event.title }}</h1>
            <p class="text-xs sm:text-sm text-white/80">📍 {{ event.location }} | 📅 {{ new Date(event.event_date).toLocaleDateString('id-ID') }}</p>
          </div>
        </div>
      </div>

      <!-- Description & Ticket Selection Grid -->
      <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 card-daebak p-6 bg-white space-y-4">
          <h2 class="font-heading text-xl text-daebak-charcoal border-b border-daebak-sage/30 pb-3">Deskripsi Event</h2>
          <p class="text-xs sm:text-sm text-daebak-charcoal/80 whitespace-pre-line leading-relaxed">
            {{ event.description }}
          </p>

          <div class="pt-4 border-t border-daebak-sage/30">
            <h3 class="font-heading text-base text-daebak-charcoal mb-2">Informasi Promotor</h3>
            <div class="flex items-center justify-between text-xs p-3 rounded-xl bg-daebak-mint/30 border border-daebak-sage/30">
              <div>
                <span class="font-bold text-daebak-charcoal block">{{ event.seller?.seller_profile?.store_name }}</span>
                <span class="text-[10px] text-daebak-charcoal/60">Promotor Terverifikasi Manual oleh Admin</span>
              </div>
              <button @click="toggleWishlist" class="px-3 py-1.5 rounded-xl border border-rose-300 bg-white text-rose-600 font-semibold text-xs">
                {{ isWishlisted ? '❤️ Ditambahkan' : '🤍 Simpan Wishlist' }}
              </button>
            </div>
          </div>
        </div>

        <!-- Ticket Category Purchasing Form -->
        <div class="card-daebak p-6 bg-white space-y-5 h-fit">
          <h3 class="font-heading text-lg text-daebak-charcoal">Pilih Kategori Tiket</h3>

          <form @submit.prevent="checkout" class="space-y-4">
            <div v-for="cat in event.categories" :key="cat.id" class="p-3.5 rounded-2xl border cursor-pointer transition-all" :class="selectedCategoryId === cat.id ? 'border-daebak-coral bg-daebak-cream/30 ring-2 ring-daebak-coral/30' : 'border-daebak-sage/40'" @click="selectedCategoryId = cat.id">
              <div class="flex items-center justify-between mb-1">
                <span class="font-bold text-sm text-daebak-charcoal">{{ cat.name }}</span>
                <input type="radio" :value="cat.id" v-model="selectedCategoryId" />
              </div>
              <p class="font-bold text-base text-daebak-charcoal">Rp {{ Number(cat.price).toLocaleString('id-ID') }}</p>
              <span class="text-[10px] text-daebak-charcoal/60 block mt-1">Sisa Kuota: {{ cat.available_quota }} Tiket</span>
            </div>

            <div>
              <label class="block text-xs font-semibold mb-1">Jumlah Tiket (Maks. 4 Per Transaksi)</label>
              <select v-model="quantity" class="w-full input-daebak text-xs bg-white font-semibold">
                <option :value="1">1 Tiket</option>
                <option :value="2">2 Tiket</option>
                <option :value="3">3 Tiket</option>
                <option :value="4">4 Tiket</option>
              </select>
            </div>

            <button type="submit" :disabled="!selectedCategoryId" class="w-full btn-daebak-primary text-xs py-3.5 font-semibold shadow-md">
              Lanjut ke Pembayaran Midtrans 💳
            </button>
          </form>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Layout from '../Layout.vue';

const props = defineProps({
  event: Object,
  isWishlisted: Boolean,
});

const selectedCategoryId = ref(props.event.categories?.[0]?.id || null);
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
