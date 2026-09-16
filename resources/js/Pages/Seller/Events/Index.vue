<template>
  <Layout title="Manajemen Event Konser" :profile="$page.props.auth.user?.seller_profile">
    <div class="space-y-6">
      <Card padding-class="p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
          <div>
            <h2 class="font-heading text-xl text-[#657166]">Kelola Seluruh Event Promotor</h2>
            <p class="text-xs text-[#657166]/70">Pantau status penjualan, kuota tiket, dan perpanjangan durasi aktif event.</p>
          </div>
          <PrimaryButton href="/seller/events/create" custom-class="text-xs font-semibold px-5 py-2.5 shadow">
            + Buat Event Baru
          </PrimaryButton>
        </div>
      </Card>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <Card
          v-for="event in events"
          :key="event.id"
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

            <h3 class="font-heading text-base text-[#657166] leading-snug">{{ event.title }}</h3>
            <p class="text-xs text-[#657166]/70">📍 {{ event.location }}</p>
            <p class="text-xs text-[#657166]/60">📅 {{ event.event_date ? new Date(event.event_date).toLocaleDateString('id-ID') : '-' }}</p>

            <div class="p-3.5 rounded-[14px] bg-[#DAEBE3]/35 border border-[#CFD6C4]/50 text-xs space-y-1">
              <div class="flex justify-between font-semibold">
                <span>Status Penjualan:</span>
                <Badge :variant="event.status === 'active' ? 'success' : 'danger'" :dot="true">
                  {{ event.status === 'active' ? 'Aktif' : 'Nonaktif' }}
                </Badge>
              </div>
              <div class="flex justify-between text-[11px] text-[#657166]/70 pt-1">
                <span>Tgl Kadaluarsa:</span>
                <span>{{ event.expires_at ? new Date(event.expires_at).toLocaleDateString('id-ID') : '-' }}</span>
              </div>
            </div>
          </div>

          <!-- Extension Actions -->
          <div class="pt-4 border-t border-[#CFD6C4]/30 mt-4 space-y-2">
            <span class="text-[10px] font-bold text-[#657166]/70 block uppercase tracking-wider">Perpanjang Durasi Event:</span>
            <div class="flex gap-2">
              <button
                type="button"
                @click="extendEvent(event.id, 5)"
                class="flex-1 py-2 bg-[#99CDD8] hover:bg-[#88bcc7] text-[#2D3A30] rounded-[12px] text-xs font-bold transition-all shadow-xs"
              >
                + 5 Hari
              </button>
              <button
                type="button"
                @click="extendEvent(event.id, 7)"
                class="flex-1 py-2 bg-[#F3C3B2] hover:bg-[#e2b2a1] text-[#4A3525] rounded-[12px] text-xs font-bold transition-all shadow-xs"
              >
                + 7 Hari
              </button>
            </div>
          </div>
        </Card>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import Layout from '../Layout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
  events: {
    type: Array,
    default: () => []
  }
});

const extendEvent = (eventId, days) => {
  if (confirm(`Apakah Anda yakin ingin memperpanjang durasi event ini selama ${days} hari?`)) {
    router.post(`/seller/events/${eventId}/extend`, { extension_days: days });
  }
};
</script>
