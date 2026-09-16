<template>
  <div class="min-h-screen bg-[#FDE8D3] font-sans text-[#657166] p-4 sm:p-6 max-w-lg mx-auto">
    <!-- Staff Header Card -->
    <Card padding-class="p-5" custom-class="mb-4 shadow-md bg-white">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-[14px] bg-[#99CDD8] text-[#2D3A30] font-heading text-lg flex items-center justify-center shadow-xs">
            📱
          </div>
          <div>
            <h1 class="font-heading text-lg text-[#657166] leading-tight">PWA Gate Scanner</h1>
            <span class="text-[11px] font-bold text-[#8C4E37] block">Toko: {{ sellerProfile?.store_name || 'Promotor Resmi' }}</span>
          </div>
        </div>
        <button
          type="button"
          @click="logout"
          class="text-xs text-[#E76F51] font-semibold hover:underline px-3 py-1.5 rounded-[10px] bg-[#FADBD8]/40"
        >
          Keluar
        </button>
      </div>

      <!-- Scanned Counter Widget -->
      <div class="mt-4 p-3.5 rounded-[16px] bg-[#DAEBE3]/50 border border-[#CFD6C4]/60 flex items-center justify-between text-xs">
        <span class="font-semibold text-[#2D3A30]">Total Tiket Sukses Discan:</span>
        <span class="font-heading text-2xl text-[#1E4D38] font-bold">{{ scannedCounter }}</span>
      </div>
    </Card>

    <!-- Event Selector -->
    <Card padding-class="p-5" custom-class="mb-4 bg-white">
      <label class="block text-xs font-bold text-[#657166] mb-2 uppercase tracking-wider">Pilih Event Pemeriksaan</label>
      <select
        v-model="selectedEventId"
        class="w-full bg-white text-[#657166] border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-xs font-semibold focus:outline-none focus:border-[#99CDD8]"
      >
        <option :value="null">-- Semua Event Promotor Ini --</option>
        <option v-for="event in events" :key="event.id" :value="event.id">
          {{ event.title }}
        </option>
      </select>
    </Card>

    <!-- Camera Scanner Widget -->
    <Card padding-class="p-5" custom-class="mb-4 space-y-4 text-center bg-white">
      <h2 class="font-heading text-lg text-[#657166]">Kamera Scanner QR Tiket</h2>
      
      <!-- Video Element Container for html5-qrcode -->
      <div id="reader" class="w-full rounded-[20px] overflow-hidden bg-slate-950 min-h-[260px] border-2 border-[#99CDD8] shadow-inner"></div>

      <div class="flex gap-2">
        <PrimaryButton
          v-if="!isScanning"
          @click="startScanner"
          custom-class="flex-1 text-xs py-3 font-semibold shadow-md"
        >
          📷 Buka Kamera Scanner
        </PrimaryButton>
        <DarkButton
          v-else
          @click="stopScanner"
          custom-class="flex-1 text-xs py-3 font-semibold"
        >
          ⏹️ Matikan Kamera
        </DarkButton>
      </div>

      <!-- Manual Input Fallback -->
      <div class="pt-3 border-t border-[#CFD6C4]/40">
        <span class="text-[11px] text-[#657166]/70 block mb-2 font-medium">Atau masukkan Kode Tiket Manual:</span>
        <div class="flex gap-2">
          <input
            type="text"
            v-model="manualCode"
            placeholder="Contoh: DBK-TIX-9901"
            class="flex-1 bg-white text-[#657166] border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3 py-2 text-xs font-mono focus:outline-none focus:border-[#99CDD8]"
          />
          <SecondaryButton
            @click="validateManual"
            :disabled="!manualCode"
            custom-class="text-xs px-4 py-2 font-semibold"
          >
            Cek Kode
          </SecondaryButton>
        </div>
      </div>
    </Card>

    <!-- Scan Result Popup / Status Alert -->
    <div v-if="scanResult" class="card-daebak p-6 bg-white shadow-2xl space-y-3 border-2 border-[#CFD6C4]/60">
      <!-- Success State -->
      <div v-if="scanResult.status === 'success'" class="text-center space-y-2">
        <div class="w-16 h-16 rounded-full bg-[#DAEBE3] text-[#1E4D38] border border-[#DAEBE3] flex items-center justify-center text-3xl mx-auto shadow-sm">
          ✅
        </div>
        <h3 class="font-heading text-2xl text-[#1E4D38]">TIKET VALID!</h3>
        <p class="text-xs text-[#657166]">{{ scanResult.message }}</p>

        <div v-if="scanResult.ticket" class="p-3.5 rounded-[14px] bg-[#DAEBE3]/30 text-left text-xs space-y-1 mt-3 border border-[#CFD6C4]/40">
          <p>• <strong>Event:</strong> {{ scanResult.ticket.event?.title }}</p>
          <p>• <strong>Kategori:</strong> {{ scanResult.ticket.category?.name }}</p>
          <p>• <strong>Nama Pemegang:</strong> {{ scanResult.ticket.buyer?.name }}</p>
          <p>• <strong>Kode:</strong> <span class="font-mono font-bold text-[#2D3A30]">{{ scanResult.ticket.ticket_code }}</span></p>
        </div>
      </div>

      <!-- Already Used State -->
      <div v-else-if="scanResult.status === 'warning'" class="text-center space-y-2">
        <div class="w-16 h-16 rounded-full bg-[#FDE8D3] text-[#8C4E37] border border-[#F3C3B2] flex items-center justify-center text-3xl mx-auto shadow-sm">
          ⚠️
        </div>
        <h3 class="font-heading text-2xl text-[#8C4E37]">TIKET SUDAH DIGUNAKAN!</h3>
        <p class="text-xs text-[#657166]">{{ scanResult.message }}</p>
      </div>

      <!-- Invalid State -->
      <div v-else class="text-center space-y-2">
        <div class="w-16 h-16 rounded-full bg-[#FADBD8] text-[#900C3F] border border-[#F5B7B1] flex items-center justify-center text-3xl mx-auto shadow-sm">
          ❌
        </div>
        <h3 class="font-heading text-2xl text-[#900C3F]">TIKET TIDAK VALID!</h3>
        <p class="text-xs text-[#657166]">{{ scanResult.message }}</p>
      </div>

      <div class="pt-2">
        <DarkButton @click="scanResult = null" custom-class="w-full text-xs py-3 font-semibold">
          Tutup & Scan Tiket Berikutnya ➔
        </DarkButton>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { Html5Qrcode } from 'html5-qrcode';
import Card from '@/Components/Card.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({
  staffUser: Object,
  sellerProfile: Object,
  events: {
    type: Array,
    default: () => []
  },
  scannedCount: {
    type: Number,
    default: 0
  },
});

const scannedCounter = ref(props.scannedCount || 0);
const selectedEventId = ref(null);
const isScanning = ref(false);
const manualCode = ref('');
const scanResult = ref(null);
let html5QrCode = null;

const startScanner = async () => {
  try {
    isScanning.value = true;
    html5QrCode = new Html5Qrcode("reader");

    await html5QrCode.start(
      { facingMode: "environment" },
      { fps: 10, qrbox: { width: 220, height: 220 } },
      (decodedText) => {
        onQrCodeScanned(decodedText);
      },
      () => {}
    );
  } catch (err) {
    console.warn("Camera start fallback/error:", err);
  }
};

const stopScanner = async () => {
  if (html5QrCode && isScanning.value) {
    await html5QrCode.stop();
    html5QrCode = null;
    isScanning.value = false;
  }
};

const onQrCodeScanned = async (code) => {
  if (html5QrCode) {
    await html5QrCode.pause();
  }
  await processCodeValidation(code);
  setTimeout(() => {
    if (html5QrCode) html5QrCode.resume();
  }, 2000);
};

const validateManual = () => {
  if (manualCode.value) {
    processCodeValidation(manualCode.value);
    manualCode.value = '';
  }
};

const processCodeValidation = async (ticketCode) => {
  try {
    const res = await axios.post('/staff/scan/validate', {
      ticket_code: ticketCode,
      event_id: selectedEventId.value,
    });

    scanResult.value = res.data;
    if (res.data.status === 'success') {
      scannedCounter.value++;
    }
  } catch (err) {
    scanResult.value = {
      status: 'error',
      message: 'Terjadi kesalahan server saat memvalidasi tiket ❌',
    };
  }
};

const logout = () => {
  if (html5QrCode) stopScanner();
  router.post('/logout');
};

onUnmounted(() => {
  if (html5QrCode) stopScanner();
});
</script>
