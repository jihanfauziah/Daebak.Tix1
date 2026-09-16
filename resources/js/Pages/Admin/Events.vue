<template>
  <Layout title="Manajemen Event & Tiket Platform">
    <div class="card-daebak p-6 bg-white">
      <h3 class="font-heading text-lg text-daebak-charcoal mb-4">Daftar Seluruh Event Korea dari Semua Seller</h3>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="event in events" :key="event.id" class="card-daebak p-5 border border-daebak-sage/30 flex flex-col justify-between">
          <div class="space-y-3">
            <div class="relative h-40 rounded-2xl overflow-hidden bg-slate-100">
              <img :src="event.banner_image" :alt="event.title" class="w-full h-full object-cover" />
              <span class="absolute top-2 right-2 bg-daebak-coral text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow uppercase">
                {{ event.category }}
              </span>
            </div>
            <div>
              <span class="text-[10px] font-bold text-daebak-blue uppercase tracking-wider">
                Toko: {{ event.seller?.seller_profile?.store_name || event.seller?.name }}
              </span>
              <h4 class="font-heading text-base text-daebak-charcoal mt-1 line-clamp-2">{{ event.title }}</h4>
              <p class="text-xs text-daebak-charcoal/70 mt-1">📍 {{ event.location }}</p>
            </div>
          </div>

          <div class="pt-4 border-t border-daebak-sage/20 mt-4 flex items-center justify-between text-xs">
            <div>
              <span class="text-[10px] text-daebak-charcoal/60">Kategori Tiket</span>
              <p class="font-bold text-daebak-charcoal">{{ event.categories?.length || 0 }} Kategori</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold" :class="event.status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'">
              {{ event.status }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

defineProps({
  events: Array
});
</script>
