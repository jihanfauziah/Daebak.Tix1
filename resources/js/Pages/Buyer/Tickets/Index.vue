<template>
  <Layout>
    <div class="space-y-6">
      <div class="card-daebak p-6 bg-white">
        <h1 class="font-heading text-2xl text-daebak-charcoal mb-2">Cari Tiket Event Korea</h1>
        <p class="text-xs text-daebak-charcoal/70 mb-4">Temukan tiket konser K-Pop, fanmeeting, dan festival budaya Korea favoritmu.</p>

        <!-- Search & Filter Bar -->
        <div class="flex flex-col sm:flex-row gap-3">
          <input
            type="text"
            v-model="searchQuery"
            @keyup.enter="applyFilters"
            placeholder="Cari berdasarkan nama idol / konser / lokasi..."
            class="flex-1 input-daebak text-sm"
          />
          <select v-model="selectedCategory" @change="applyFilters" class="input-daebak text-sm bg-white font-medium">
            <option value="all">Semua Kategori</option>
            <option value="concert">Konser Idol</option>
            <option value="fanmeeting">Fanmeeting</option>
            <option value="cultural">Festival Budaya</option>
          </select>
          <button @click="applyFilters" class="btn-daebak-primary text-xs py-2.5 px-6 font-semibold">
            Cari Event 🔍
          </button>
        </div>
      </div>

      <!-- Events Grid -->
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="event in events" :key="event.id" class="card-daebak p-5 bg-white flex flex-col justify-between hover:border-daebak-blue">
          <div class="space-y-3">
            <div class="relative h-44 rounded-2xl overflow-hidden bg-slate-100">
              <img :src="event.banner_image" :alt="event.title" class="w-full h-full object-cover" />
              <span class="absolute top-3 right-3 bg-daebak-coral text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase shadow">
                {{ event.category }}
              </span>
            </div>

            <div>
              <span class="text-[10px] font-bold text-daebak-blue uppercase">
                Promotor: {{ event.seller?.seller_profile?.store_name || 'Promotor Resmi' }}
              </span>
              <h3 class="font-heading text-base text-daebak-charcoal mt-1 line-clamp-2">{{ event.title }}</h3>
              <p class="text-xs text-daebak-charcoal/70 mt-1">📍 {{ event.location }}</p>
            </div>
          </div>

          <div class="pt-4 border-t border-daebak-sage/20 mt-4 flex items-center justify-between">
            <div>
              <span class="text-[10px] text-daebak-charcoal/60">Harga Tiket</span>
              <p class="font-bold text-daebak-charcoal text-sm">
                Rp {{ Number(event.categories?.[0]?.price || 0).toLocaleString('id-ID') }}
              </p>
            </div>
            <a :href="`/tickets/${event.slug}`" class="btn-daebak-primary text-xs py-2 px-4">
              Lihat Rincian ➔
            </a>
          </div>
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
  events: Array,
  filters: Object,
});

const searchQuery = ref(props.filters?.search || '');
const selectedCategory = ref(props.filters?.category || 'all');

const applyFilters = () => {
  router.get('/tickets', {
    search: searchQuery.value,
    category: selectedCategory.value,
  }, { preserveState: true });
};
</script>
