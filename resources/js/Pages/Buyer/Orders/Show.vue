<template>
  <Layout>
    <div class="max-w-2xl mx-auto space-y-6">
      <!-- Order Header Card -->
      <div class="card-daebak p-6 bg-white border border-daebak-sage/40">
        <div class="flex items-center justify-between border-b border-daebak-sage/30 pb-4 mb-4">
          <div>
            <span class="text-[10px] text-daebak-charcoal/60 uppercase font-bold block">Nomor Pesanan (Order ID)</span>
            <span class="font-mono font-bold text-base text-daebak-charcoal">{{ order.order_number }}</span>
          </div>
          <span class="px-3 py-1 rounded-full text-xs font-bold" :class="order.payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'">
            {{ order.payment_status === 'paid' ? 'LUNAS (Paid) ✅' : 'MENUNGGU PEMBAYARAN ⏳' }}
          </span>
        </div>

        <div class="space-y-3 text-xs">
          <div class="flex justify-between">
            <span class="text-daebak-charcoal/70">Nama Event:</span>
            <span class="font-semibold text-daebak-charcoal">{{ order.event?.title }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-daebak-charcoal/70">Penyelenggara Toko:</span>
            <span class="font-semibold text-daebak-blue">{{ order.seller?.seller_profile?.store_name || '-' }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-daebak-charcoal/70">Jumlah Tiket:</span>
            <span class="font-semibold text-daebak-charcoal">{{ order.tickets?.length || 1 }} Tiket</span>
          </div>
          <div class="flex justify-between border-t border-daebak-sage/20 pt-3 text-sm font-bold">
            <span>Total Pembayaran:</span>
            <span class="text-daebak-charcoal">Rp {{ Number(order.total_amount).toLocaleString('id-ID') }}</span>
          </div>
        </div>
      </div>

      <!-- Midtrans Payment Simulator Section -->
      <div v-if="order.payment_status === 'pending'" class="card-daebak p-6 bg-white border-2 border-daebak-coral space-y-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-daebak-coral text-white flex items-center justify-center font-bold text-xl">
            💳
          </div>
          <div>
            <h3 class="font-heading text-lg text-daebak-charcoal">Midtrans Payment Gateway Simulator</h3>
            <p class="text-xs text-daebak-charcoal/70">Simulasikan pembayaran instant sandbox (QRIS / VA / E-Wallet)</p>
          </div>
        </div>

        <div class="p-4 rounded-2xl bg-daebak-cream/40 border border-daebak-sage/40 text-xs space-y-3">
          <p class="font-semibold text-daebak-charcoal">Pilih Metode Simulasi Pembayaran Sandbox:</p>

          <div class="grid grid-cols-2 gap-3">
            <button @click="payWithMethod('QRIS Sandbox')" class="p-3 rounded-xl bg-white border border-daebak-sage hover:border-daebak-coral font-bold text-xs flex items-center justify-center gap-2">
              <span>📱 QRIS Sandbox</span>
            </button>
            <button @click="payWithMethod('BCA Virtual Account')" class="p-3 rounded-xl bg-white border border-daebak-sage hover:border-daebak-coral font-bold text-xs flex items-center justify-center gap-2">
              <span>🏦 BCA VA Sandbox</span>
            </button>
          </div>
        </div>

        <button @click="payWithMethod('QRIS Instant Simulator')" :disabled="processing" class="w-full btn-daebak-primary py-3.5 text-xs font-semibold shadow-lg">
          <span v-if="processing">Memproses Pembayaran...</span>
          <span v-else>Bayar Sekarang Via Simulator (Instant Paid) 🚀</span>
        </button>
      </div>

      <!-- Paid Success Locker Banner -->
      <div v-else class="card-daebak p-6 card-soft-gradient text-center space-y-3">
        <div class="w-14 h-14 rounded-full bg-emerald-500 text-white flex items-center justify-center text-2xl mx-auto shadow-md">
          ✓
        </div>
        <h3 class="font-heading text-xl text-daebak-charcoal">Pembayaran Berhasil!</h3>
        <p class="text-xs text-daebak-charcoal/80">Tiket digital dengan QR Code asli milikmu telah tersedia di menu Tiket Digital.</p>
        <a href="/my-tickets" class="inline-block btn-daebak-dark text-xs py-3 px-6 shadow-md mt-2">
          Buka Tiket Digital & QR Code 📲
        </a>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Layout from '../Layout.vue';

const props = defineProps({
  order: Object,
  midtransClientKey: String,
});

const processing = ref(false);

const payWithMethod = (method) => {
  processing.value = true;
  router.post(`/orders/${props.order.id}/simulate-payment`, {
    payment_method: method
  }, {
    onFinish: () => {
      processing.value = false;
    }
  });
};
</script>
