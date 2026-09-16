<template>
  <Layout>
    <div class="card-daebak p-6 bg-white">
      <h1 class="font-heading text-xl text-daebak-charcoal mb-4">Riwayat Order Saya</h1>

      <div class="space-y-4">
        <div v-for="order in orders" :key="order.id" class="p-5 rounded-2xl border border-daebak-sage/30 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
          <div class="space-y-1">
            <span class="font-mono font-bold text-xs text-daebak-charcoal">{{ order.order_number }}</span>
            <h3 class="font-heading text-base text-daebak-charcoal">{{ order.event?.title }}</h3>
            <p class="text-xs text-daebak-charcoal/70">Total: <strong>Rp {{ Number(order.total_amount).toLocaleString('id-ID') }}</strong> ({{ order.tickets?.length || 1 }} Tiket)</p>
          </div>

          <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-[10px] font-bold" :class="order.payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'">
              {{ order.payment_status }}
            </span>
            <a :href="`/orders/${order.id}`" class="btn-daebak-primary text-xs py-2 px-4">
              Detail Order ➔
            </a>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from '../Layout.vue';

defineProps({
  orders: Array
});
</script>
