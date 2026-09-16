<template>
  <Layout title="My Events Management" :profile="$page.props.auth.user?.seller_profile">
    <div class="card-daebak p-6 bg-white mb-6">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="font-heading text-lg text-daebak-charcoal">Kelola Seluruh Event Toko</h2>
          <p class="text-xs text-daebak-charcoal/70">Lihat status penjualan, statistik tiket, dan perpanjangan durasi event.</p>
        </div>
        <a href="/seller/events/create" class="btn-daebak-primary text-xs font-semibold px-5 py-2.5 shadow">
          + Buat Event Baru
        </a>
      </div>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="event in events" :key="event.id" class="card-daebak p-5 bg-white flex flex-col justify-between">
        <div class="space-y-3">
          <div class="relative h-44 rounded-2xl overflow-hidden bg-slate-100">
            <img :src="event.banner_image" :alt="event.title" class="w-full h-full object-cover" />
            <span class="absolute top-3 right-3 bg-daebak-coral text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
              {{ event.category }}
            </span>
          </div>

          <h3 class="font-heading text-base text-daebak-charcoal">{{ event.title }}</h3>
          <p class="text-xs text-daebak-charcoal/70">📍 {{ event.location }}</p>
          <p class="text-xs text-daebak-charcoal/60">📅 {{ new Date(event.event_date).toLocaleDateString('id-ID') }}</p>

          <div class="p-3 rounded-xl bg-daebak-mint/30 border border-daebak-sage/30 text-xs space-y-1">
            <div class="flex justify-between font-semibold">
              <span>Status Penjualan:</span>
              <span :class="event.status === 'active' ? 'text-emerald-700' : 'text-rose-600'">{{ event.status }}</span>
            </div>
            <div class="flex justify-between text-[11px] text-daebak-charcoal/70">
              <span>Tgl Kadaluarsa:</span>
              <span>{{ event.expires_at ? new Date(event.expires_at).toLocaleDateString('id-ID') : '-' }}</span>
            </div>
          </div>
        </div>

        <!-- Extension Actions -->
        <div class="pt-4 border-t border-daebak-sage/20 mt-4 space-y-2">
          <span class="text-[10px] font-bold text-daebak-charcoal/70 block">Perpanjang Durasi Penjualan (Opsi 5 atau 7 Hari):</span>
          <div class="flex gap-2">
            <button @click="extendEvent(event.id, 5)" class="flex-1 py-2 bg-daebak-blue/80 hover:bg-daebak-blue text-daebak-charcoal rounded-xl text-xs font-bold transition-all shadow-sm">
              + 5 Hari
            </button>
            <button @click="extendEvent(event.id, 7)" class="flex-1 py-2 bg-daebak-coral/80 hover:bg-daebak-coral text-white rounded-xl text-xs font-bold transition-all shadow-sm">
              + 7 Hari
            </button>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import Layout from '../Layout.vue';

defineProps({
  events: Array
});

const extendEvent = (eventId, days) => {
  if (confirm(`Apakah Anda yakin ingin memperpanjang durasi event ini selama ${days} hari?`)) {
    router.post(`/seller/events/${eventId}/extend`, { extension_days: days });
  }
};
</script>
