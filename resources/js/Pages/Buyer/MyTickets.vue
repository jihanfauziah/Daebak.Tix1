<template>
  <Layout title="Tiket Digital Saya" subtitle="Tunjukkan QR Code unik ini ke petugas gate saat masuk ke venue acara.">
    <div class="space-y-6">
      <div v-if="tickets.length === 0">
        <Card padding-class="p-12" custom-class="text-center space-y-4">
          <span class="text-5xl block">🎟️</span>
          <h3 class="font-heading text-2xl text-[#657166]">Belum Ada Tiket Digital</h3>
          <p class="text-sm text-[#657166]/70 max-w-md mx-auto">
            Anda belum memiliki tiket aktif. Jelajahi konser dan fanmeeting K-Pop terbaru untuk mendapatkan tiket digital resmi.
          </p>
          <div class="pt-2">
            <PrimaryButton href="/tickets" custom-class="text-sm px-6 py-3">
              Cari Tiket Konser ➔
            </PrimaryButton>
          </div>
        </Card>
      </div>

      <div v-else class="grid md:grid-cols-2 gap-8">
        <Card
          v-for="ticket in tickets"
          :key="ticket.id"
          padding-class="p-6"
          custom-class="flex flex-col justify-between border-2 border-[#CFD6C4]/60 bg-white relative overflow-hidden"
        >
          <!-- Top Event Card Info -->
          <div class="space-y-4">
            <div class="flex items-start justify-between border-b border-[#CFD6C4]/40 pb-4">
              <div>
                <Badge variant="coral">{{ ticket.event?.category }}</Badge>
                <h3 class="font-heading text-xl text-[#657166] mt-2 leading-tight">{{ ticket.event?.title }}</h3>
                <p class="text-xs text-[#657166]/70 mt-1">📍 {{ ticket.event?.location }}</p>
              </div>
              <Badge :variant="ticket.status === 'valid' ? 'success' : 'used'" :dot="true">
                {{ ticket.status === 'valid' ? 'Aktif (Valid)' : 'Sudah Digunakan' }}
              </Badge>
            </div>

            <div class="grid grid-cols-2 gap-2 text-xs text-[#657166] p-3 rounded-[16px] bg-[#FDE8D3]/30 border border-[#CFD6C4]/40">
              <div>
                <span class="text-[#657166]/70 block text-[11px]">Kategori Tiket</span>
                <span class="font-bold font-sans text-sm text-[#2D3A30]">{{ ticket.category?.name }}</span>
              </div>
              <div>
                <span class="text-[#657166]/70 block text-[11px]">Tanggal Event</span>
                <span class="font-semibold text-sm">{{ ticket.event?.event_date ? new Date(ticket.event.event_date).toLocaleDateString('id-ID') : '-' }}</span>
              </div>
            </div>

            <!-- Dynamic QR Code SVG Rendering -->
            <div class="p-6 rounded-[20px] bg-[#DAEBE3]/35 border border-[#CFD6C4]/50 flex flex-col items-center justify-center text-center space-y-3">
              <div
                v-html="ticket.qr_code_svg"
                class="w-48 h-48 bg-white p-3 rounded-[16px] shadow-[0_2px_12px_rgba(101,113,102,0.1)] flex items-center justify-center border border-[#CFD6C4]/40"
              ></div>
              <div class="space-y-1">
                <span class="text-[10px] text-[#657166]/70 uppercase tracking-widest font-bold">Kode Tiket Unik</span>
                <p class="font-mono text-base font-bold text-[#657166] tracking-wider select-all">{{ ticket.ticket_code }}</p>
              </div>
            </div>
          </div>

          <div class="mt-4 pt-3 border-t border-[#CFD6C4]/30 flex items-center justify-between text-[11px] text-[#657166]/70">
            <span>🔒 1 Tiket = 1 Kali Scan PWA</span>
            <span class="font-semibold">Daebak.Tix Security</span>
          </div>
        </Card>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
  tickets: {
    type: Array,
    default: () => []
  }
});
</script>
