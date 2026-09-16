<template>
  <Layout title="Katalog Tiket Event Korea" subtitle="Jelajahi konser, fanmeeting, dan festival K-Pop resmi.">
    <div class="space-y-6">
      <Card padding-class="p-6">
        <!-- Search & Filter Bar -->
        <div class="flex flex-col sm:flex-row gap-3">
          <input
            type="text"
            v-model="searchQuery"
            @keyup.enter="applyFilters"
            placeholder="Cari berdasarkan nama artis / konser / venue..."
            class="flex-1 bg-white text-[#657166] placeholder-[#657166]/40 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans focus:outline-none focus:border-[#99CDD8]"
          />
          <select
            v-model="selectedCategory"
            @change="applyFilters"
            class="bg-white text-[#657166] border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans focus:outline-none focus:border-[#99CDD8]"
          >
            <option value="all">Semua Kategori</option>
            <option value="concert">Konser Idol</option>
            <option value="fanmeeting">Fanmeeting</option>
            <option value="cultural">Festival Budaya</option>
          </select>
          <PrimaryButton @click="applyFilters" custom-class="text-sm px-6 py-2.5">
            Cari Event 🔍
          </PrimaryButton>
        </div>
      </Card>

      <!-- Events Grid -->
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <Card
          v-for="event in events"
          :key="event.id"
          hoverable
          padding-class="p-5"
          custom-class="flex flex-col justify-between"
        >
          <div class="space-y-3">
            <div class="relative h-44 rounded-[16px] overflow-hidden bg-[#DAEBE3]/40">
              <img :src="event.banner_image" :alt="event.title" class="w-full h-full object-cover" />
              <div class="absolute top-3 right-3">
                <Badge variant="coral">{{ event.category }}</Badge>
              </div>
            </div>

            <div>
              <span class="text-[10px] font-bold text-[#8C4E37] uppercase tracking-wider">
                Promotor: {{ event.seller?.seller_profile?.store_name || 'Promotor Resmi' }}
              </span>
              <h3 class="font-heading text-lg text-[#657166] mt-1 line-clamp-2 leading-snug">{{ event.title }}</h3>
              <p class="text-xs text-[#657166]/70 mt-1">📍 {{ event.location }}</p>
              <p class="text-xs text-[#657166]/60 mt-0.5">📅 {{ event.event_date ? new Date(event.event_date).toLocaleDateString('id-ID') : '-' }}</p>
            </div>
          </div>

          <div class="pt-4 border-t border-[#CFD6C4]/30 mt-4 flex items-center justify-between">
            <div>
              <span class="text-[10px] text-[#657166]/60">Harga Tiket Mulai</span>
              <p class="font-bold text-[#657166] text-base font-sans">
                Rp {{ Number(event.categories?.[0]?.price || 0).toLocaleString('id-ID') }}
              </p>
            </div>
            <PrimaryButton :href="`/tickets/${event.slug}`" custom-class="text-xs py-2 px-4">
              Pesan Tiket ➔
            </PrimaryButton>
          </div>
        </Card>
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
  events: {
    type: Array,
    default: () => []
  },
  filters: {
    type: Object,
    default: () => ({})
  },
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
