<template>
  <Layout>
    <div class="space-y-6">
      <div class="card-daebak p-6 bg-white">
        <h1 class="font-heading text-2xl text-daebak-charcoal mb-2">Tiket Digital & QR Code Saya</h1>
        <p class="text-xs text-daebak-charcoal/70">Tunjukkan QR Code unik ini di lokasi event untuk discan oleh petugas staf lapangan.</p>
      </div>

      <div v-if="tickets.length === 0" class="card-daebak p-12 bg-white text-center space-y-4">
        <span class="text-4xl">🎟️</span>
        <h3 class="font-heading text-lg text-daebak-charcoal">Belum Ada Tiket Digital</h3>
        <p class="text-xs text-daebak-charcoal/70">Anda belum memiliki tiket aktif. Silakan jelajahi katalog tiket event Korea kami.</p>
        <a href="/tickets" class="inline-block btn-daebak-primary text-xs py-3 px-6 font-semibold">
          Cari Tiket Konser ➔
        </a>
      </div>

      <div class="grid md:grid-cols-2 gap-8">
        <div v-for="ticket in tickets" :key="ticket.id" class="card-daebak p-6 bg-white border-2 border-daebak-sage/40 flex flex-col justify-between relative overflow-hidden shadow-lg">
          <!-- Top Event Card Info -->
          <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-daebak-sage/30 pb-3">
              <div>
                <span class="bg-daebak-coral text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                  {{ ticket.event?.category }}
                </span>
                <h3 class="font-heading text-lg text-daebak-charcoal mt-1">{{ ticket.event?.title }}</h3>
              </div>
              <span class="px-3 py-1 rounded-full text-[10px] font-bold" :class="ticket.status === 'valid' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'">
                {{ ticket.status === 'valid' ? 'Aktif (Belum Discan) ✅' : 'Sudah Digunakan ❌' }}
              </span>
            </div>

            <div class="space-y-1 text-xs text-daebak-charcoal/80">
              <p>• <strong>Kategori Tiket:</strong> {{ ticket.category?.name }}</p>
              <p>• <strong>Lokasi:</strong> {{ ticket.event?.location }}</p>
              <p>• <strong>Tanggal Event:</strong> {{ new Date(ticket.event?.event_date).toLocaleDateString('id-ID') }}</p>
            </div>

            <!-- Dynamic QR Code SVG Rendering -->
            <div class="p-6 rounded-2xl bg-daebak-cream/40 border border-daebak-sage/40 flex flex-col items-center justify-center text-center space-y-3">
              <div v-html="ticket.qr_code_svg" class="w-48 h-48 bg-white p-3 rounded-xl shadow-md flex items-center justify-center"></div>
              <div class="space-y-1">
                <span class="text-[10px] text-daebak-charcoal/60 uppercase tracking-widest font-bold">Kode Tiket Unik</span>
                <p class="font-mono text-base font-bold text-daebak-charcoal tracking-wider">{{ ticket.ticket_code }}</p>
              </div>
            </div>
          </div>

          <div class="mt-4 pt-3 border-t border-daebak-sage/20 text-center text-[10px] text-daebak-charcoal/50 font-semibold">
            Daebak.Tix Verification System • 1 Tiket = 1 Kali Scan
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

defineProps({
  tickets: Array
});
</script>
