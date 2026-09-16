<template>
  <Layout title="Riwayat Pesanan Saya" subtitle="Daftar seluruh transaksi pemesanan tiket Anda.">
    <div class="space-y-4">
      <div v-if="orders.length === 0">
        <Card padding-class="p-12" custom-class="text-center space-y-3">
          <span class="text-4xl block">📦</span>
          <h3 class="font-heading text-xl text-[#657166]">Belum Ada Riwayat Pesanan</h3>
          <p class="text-xs text-[#657166]/70">Anda belum pernah melakukan pemesanan tiket di Daebak.Tix.</p>
        </Card>
      </div>

      <div v-else class="space-y-4">
        <Card
          v-for="order in orders"
          :key="order.id"
          padding-class="p-5"
          custom-class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
        >
          <div class="space-y-1">
            <span class="font-mono font-bold text-xs text-[#657166]/70">{{ order.order_number }}</span>
            <h3 class="font-heading text-base text-[#657166]">{{ order.event?.title }}</h3>
            <p class="text-xs text-[#657166]/75">
              Total: <strong class="text-[#2D3A30]">Rp {{ Number(order.total_amount).toLocaleString('id-ID') }}</strong> • {{ order.tickets?.length || 1 }} Tiket
            </p>
          </div>

          <div class="flex items-center gap-3">
            <Badge :variant="order.payment_status === 'paid' ? 'success' : 'warning'" :dot="true">
              {{ order.payment_status }}
            </Badge>
            <PrimaryButton :href="`/orders/${order.id}`" custom-class="text-xs py-2 px-4">
              Detail Order ➔
            </PrimaryButton>
          </div>
        </Card>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from '../Layout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
  orders: {
    type: Array,
    default: () => []
  }
});
</script>
