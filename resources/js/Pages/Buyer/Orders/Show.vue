<template>
  <Layout title="Detail Pesanan Tiket" subtitle="Rincian tagihan dan status pembayaran resmi Midtrans.">
    <div class="max-w-2xl mx-auto space-y-6">
      <!-- Order Header Card -->
      <Card padding-class="p-6">
        <div class="flex items-center justify-between border-b border-[#CFD6C4]/40 pb-4 mb-4">
          <div>
            <span class="text-[10px] text-[#657166]/70 uppercase font-bold tracking-wider block">Order ID</span>
            <span class="font-mono font-bold text-base text-[#657166]">{{ order.order_number }}</span>
          </div>
          <Badge :variant="order.payment_status === 'paid' ? 'success' : 'warning'" :dot="true">
            {{ order.payment_status === 'paid' ? 'Lunas (Paid)' : 'Menunggu Pembayaran' }}
          </Badge>
        </div>

        <div class="space-y-3 text-xs text-[#657166]">
          <div class="flex justify-between">
            <span class="text-[#657166]/70">Event:</span>
            <span class="font-semibold text-sm">{{ order.event?.title }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-[#657166]/70">Promotor:</span>
            <span class="font-semibold text-[#8C4E37]">{{ order.seller?.seller_profile?.store_name || '-' }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-[#657166]/70">Jumlah Tiket:</span>
            <span class="font-semibold">{{ order.tickets?.length || 1 }} Tiket</span>
          </div>
          <div class="flex justify-between border-t border-[#CFD6C4]/40 pt-3 text-base font-bold">
            <span>Total Tagihan:</span>
            <span class="text-[#657166]">Rp {{ Number(order.total_amount).toLocaleString('id-ID') }}</span>
          </div>
        </div>
      </Card>

      <!-- Midtrans Payment Simulator Section -->
      <div v-if="order.payment_status === 'pending'">
        <Card padding-class="p-6" custom-class="border-2 border-[#99CDD8] space-y-4">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-[14px] bg-[#99CDD8] text-[#2D3A30] flex items-center justify-center font-bold text-lg shadow-sm">
              💳
            </div>
            <div>
              <h3 class="font-heading text-lg text-[#657166]">Midtrans Payment Gateway Simulator</h3>
              <p class="text-xs text-[#657166]/70">Simulasi pembayaran Sandbox (QRIS & Virtual Account)</p>
            </div>
          </div>

          <div class="p-4 rounded-[16px] bg-[#DAEBE3]/40 border border-[#CFD6C4]/40 text-xs space-y-3">
            <p class="font-semibold text-[#657166]">Pilih Saluran Pembayaran Sandbox:</p>

            <div class="grid grid-cols-2 gap-3">
              <button
                type="button"
                @click="payWithMethod('QRIS Sandbox')"
                class="p-3 rounded-[12px] bg-white border border-[#CFD6C4] hover:border-[#99CDD8] font-bold text-xs text-[#657166] flex items-center justify-center gap-2 transition-all shadow-xs"
              >
                <span>📱 QRIS Instant</span>
              </button>
              <button
                type="button"
                @click="payWithMethod('BCA Virtual Account')"
                class="p-3 rounded-[12px] bg-white border border-[#CFD6C4] hover:border-[#99CDD8] font-bold text-xs text-[#657166] flex items-center justify-center gap-2 transition-all shadow-xs"
              >
                <span>🏦 BCA VA Sandbox</span>
              </button>
            </div>
          </div>

          <PrimaryButton
            @click="payWithMethod('QRIS Instant Simulator')"
            :loading="processing"
            custom-class="w-full py-3.5 text-sm font-semibold shadow-md"
          >
            Bayar Sekarang (Simulasi Lunas) 🚀
          </PrimaryButton>
        </Card>
      </div>

      <!-- Paid Success Locker Banner -->
      <div v-else>
        <Card padding-class="p-8" custom-class="text-center space-y-3 bg-gradient-to-br from-[#DAEBE3] to-[#99CDD8]/30 border border-[#CFD6C4]/60">
          <div class="w-14 h-14 rounded-full bg-[#DAEBE3] text-[#1E4D38] border border-[#DAEBE3] flex items-center justify-center text-2xl mx-auto shadow-sm">
            ✓
          </div>
          <h3 class="font-heading text-2xl text-[#657166]">Pembayaran Berhasil!</h3>
          <p class="text-xs text-[#657166]/80 max-w-sm mx-auto">
            Tiket digital dengan QR Code asli telah aktif dan siap digunakan saat event.
          </p>
          <div class="pt-2">
            <DarkButton href="/my-tickets" custom-class="text-xs py-3 px-6 shadow-md">
              Buka Tiket Digital & QR Code 📲
            </DarkButton>
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
import DarkButton from '@/Components/DarkButton.vue';

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
