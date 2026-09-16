<template>
  <Layout title="Orders Masuk Event Toko" :profile="$page.props.auth.user?.seller_profile">
    <div class="card-daebak p-6 bg-white">
      <h3 class="font-heading text-lg text-daebak-charcoal mb-4">Daftar Pesanan Tiket Masuk</h3>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead>
            <tr class="border-b border-daebak-sage/40 text-daebak-charcoal/60 uppercase">
              <th class="py-3 px-4">No. Order</th>
              <th class="py-3 px-4">Pembeli</th>
              <th class="py-3 px-4">Event Korea</th>
              <th class="py-3 px-4">Jumlah Tiket</th>
              <th class="py-3 px-4">Total Bayar</th>
              <th class="py-3 px-4">Status Pembayaran</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-daebak-sage/20">
            <tr v-for="order in orders" :key="order.id">
              <td class="py-3.5 px-4 font-mono font-bold">{{ order.order_number }}</td>
              <td class="py-3.5 px-4 font-semibold">{{ order.buyer?.name }}</td>
              <td class="py-3.5 px-4 font-medium">{{ order.event?.title }}</td>
              <td class="py-3.5 px-4 font-bold">{{ order.tickets?.length || 1 }} Tiket</td>
              <td class="py-3.5 px-4 font-bold">Rp {{ Number(order.total_amount).toLocaleString('id-ID') }}</td>
              <td class="py-3.5 px-4">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold" :class="order.payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'">
                  {{ order.payment_status }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

defineProps({
  orders: Array
});
</script>
