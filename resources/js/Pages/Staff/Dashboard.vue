<template>
  <div class="min-h-screen bg-daebak-cream font-sans text-daebak-charcoal p-4 max-w-md mx-auto">
    <!-- Staff Header Card -->
    <div class="card-daebak p-5 bg-white mb-4 shadow-md">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-daebak-coral text-white font-heading text-lg flex items-center justify-center shadow">
            📱
          </div>
          <div>
            <h1 class="font-heading text-lg text-daebak-charcoal">PWA Staff Scan</h1>
            <span class="text-[11px] font-bold text-daebak-blue block">Toko: {{ sellerProfile?.store_name || 'Seller Store' }}</span>
          </div>
        </div>
        <button @click="logout" class="text-xs text-rose-600 font-semibold hover:underline">
          Logout
        </button>
      </div>

      <!-- Scanned Counter Widget -->
      <div class="mt-4 p-3 rounded-xl bg-daebak-mint/50 border border-daebak-sage/40 flex items-center justify-between text-xs">
        <span class="font-semibold text-daebak-charcoal">Total Tiket Berhasil Discan:</span>
        <span class="font-heading text-xl text-emerald-700 font-bold">{{ scannedCounter }}</span>
      </div>
    </div>

    <!-- Event Selector -->
    <div class="card-daebak p-5 bg-white mb-4">
      <label class="block text-xs font-bold text-daebak-charcoal mb-2 uppercase">Pilih Event Yang Sedang Di-scan</label>
      <select v-model="selectedEventId" class="w-full input-daebak text-xs bg-white font-semibold">
        <option :value="null">-- Semua Event Seller Ini --</option>
        <option v-for="event in events" :key="event.id" :value="event.id">
          {{ event.title }}
        </option>
      </select>
    </div>

    <!-- Camera Scanner Widget -->
    <div class="card-daebak p-5 bg-white mb-4 space-y-4 text-center">
      <h2 class="font-heading text-base text-daebak-charcoal">Kamera Scanner QR Code</h2>
      
      <!-- Video Element Container for html5-qrcode -->
      <div id="reader" class="w-full rounded-2xl overflow-hidden bg-slate-950 min-h-[260px] border-2 border-daebak-blue"></div>

      <div class="flex gap-2">
        <button v-if="!isScanning" @click="startScanner" class="flex-1 btn-daebak-primary text-xs py-3 font-semibold shadow">
          📷 Buka Kamera Scanner
        </button>
        <button v-else @click="stopScanner" class="flex-1 btn-daebak-dark text-xs py-3 font-semibold">
          ⏹️ Matikan Kamera
        </button>
      </div>

      <!-- Manual Input Fallback -->
      <div class="pt-2 border-t border-daebak-sage/30">
        <span class="text-[11px] text-daebak-charcoal/60 block mb-2">Atau masukkan Kode Tiket Manual:</span>
        <div class="flex gap-2">
          <input type="text" v-model="manualCode" placeholder="Contoh: TIX-BP-VIP-9901" class="flex-1 input-daebak text-xs font-mono" />
          <button @click="validateManual" :disabled="!manualCode" class="btn-daebak-secondary text-xs px-4 py-2 font-semibold">
            Cek Kode
          </button>
        </div>
      </div>
    </div>

    <!-- Scan Result Popup / Status Alert -->
    <div v-if="scanResult" class="card-daebak p-6 bg-white shadow-2xl space-y-3 transition-all animate-bounce-short">
      <!-- Success State -->
      <div v-if="scanResult.status === 'success'" class="text-center space-y-2">
        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl mx-auto">
          ✅
        </div>
        <h3 class="font-heading text-xl text-emerald-700">TIKET VALID!</h3>
        <p class="text-xs text-daebak-charcoal/80">{{ scanResult.message }}</p>

        <div v-if="scanResult.ticket" class="p-3 rounded-xl bg-slate-50 text-left text-xs space-y-1 mt-3">
          <p>• <strong>Event:</strong> {{ scanResult.ticket.event?.title }}</p>
          <p>• <strong>Kategori:</strong> {{ scanResult.ticket.category?.name }}</p>
          <p>• <strong>Nama Pemegang:</strong> {{ scanResult.ticket.buyer?.name }}</p>
          <p>• <strong>Kode:</strong> <span class="font-mono">{{ scanResult.ticket.ticket_code }}</span></p>
        </div>
      </div>

      <!-- Already Used State -->
      <div v-else-if="scanResult.status === 'warning'" class="text-center space-y-2">
        <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-3xl mx-auto">
          ⚠️
        </div>
        <h3 class="font-heading text-xl text-amber-700">TIKET SUDAH DIGUNAKAN!</h3>
        <p class="text-xs text-daebak-charcoal/80">{{ scanResult.message }}</p>
      </div>

      <!-- Invalid State -->
      <div v-else class="text-center space-y-2">
        <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-3xl mx-auto">
          ❌
        </div>
        <h3 class="font-heading text-xl text-rose-700">TIKET TIDAK VALID!</h3>
        <p class="text-xs text-daebak-charcoal/80">{{ scanResult.message }}</p>
      </div>

      <button @click="scanResult = null" class="w-full btn-daebak-dark text-xs py-2.5 font-semibold mt-2">
        Tutup & Scan Tiket Berikutnya ➔
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { Html5Qrcode } from 'html5-qrcode';

const props = defineProps({
  staffUser: Object,
  sellerProfile: Object,
  events: Array,
  scannedCount: Number,
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
