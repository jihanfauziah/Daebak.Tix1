<template>
  <Layout title="Orders Masuk Event Toko" :profile="$page.props.auth.user?.seller_profile">
    <Card padding-class="p-6">
      <h3 class="font-heading text-xl text-[#657166] mb-4">Daftar Transaksi Tiket Masuk</h3>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead>
            <tr class="border-b border-[#CFD6C4]/50 text-[#657166]/70 uppercase">
              <th class="py-3 px-4 font-bold">No. Order</th>
              <th class="py-3 px-4 font-bold">Pembeli</th>
              <th class="py-3 px-4 font-bold">Event Korea</th>
              <th class="py-3 px-4 font-bold">Jumlah</th>
              <th class="py-3 px-4 font-bold">Total Tagihan</th>
              <th class="py-3 px-4 font-bold">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#CFD6C4]/30">
            <tr v-for="order in orders" :key="order.id">
              <td class="py-3.5 px-4 font-mono font-bold text-xs text-[#2D3A30]">{{ order.order_number }}</td>
              <td class="py-3.5 px-4 font-semibold text-sm">{{ order.buyer?.name }}</td>
              <td class="py-3.5 px-4 font-medium text-[#657166]">{{ order.event?.title }}</td>
              <td class="py-3.5 px-4 font-bold">{{ order.tickets?.length || 1 }} Tiket</td>
              <td class="py-3.5 px-4 font-bold text-[#2D3A30]">Rp {{ Number(order.total_amount).toLocaleString('id-ID') }}</td>
              <td class="py-3.5 px-4">
                <Badge :variant="order.payment_status === 'paid' ? 'success' : 'warning'" :dot="true">
                  {{ order.payment_status }}
                </Badge>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </Card>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';

defineProps({
  orders: {
    type: Array,
    default: () => []
  }
});
</script>
