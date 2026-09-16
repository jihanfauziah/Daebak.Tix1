<template>
  <Layout title="Laporan Transaksi Pembelian">
    <div class="card-daebak p-6 bg-white">
      <h3 class="font-heading text-lg text-daebak-charcoal mb-4">Riwayat Transaksi Penjualan & Pembelian</h3>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead>
            <tr class="border-b border-daebak-sage/40 text-daebak-charcoal/60 uppercase">
              <th class="py-3 px-4">No. Order</th>
              <th class="py-3 px-4">Pembeli</th>
              <th class="py-3 px-4">Event & Seller</th>
              <th class="py-3 px-4">Total Bayar</th>
              <th class="py-3 px-4">Metode</th>
              <th class="py-3 px-4">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-daebak-sage/20">
            <tr v-for="tx in transactions" :key="tx.id">
              <td class="py-3.5 px-4 font-mono font-bold">{{ tx.order_number }}</td>
              <td class="py-3.5 px-4">
                <div class="font-semibold">{{ tx.buyer?.name || '-' }}</div>
                <span class="text-[10px] text-daebak-charcoal/60">{{ tx.buyer?.email }}</span>
              </td>
              <td class="py-3.5 px-4">
                <div class="font-semibold text-daebak-charcoal">{{ tx.event?.title || '-' }}</div>
                <span class="text-[10px] text-daebak-blue font-bold">Toko: {{ tx.seller?.seller_profile?.store_name || '-' }}</span>
              </td>
              <td class="py-3.5 px-4 font-bold text-daebak-charcoal">
                Rp {{ Number(tx.total_amount).toLocaleString('id-ID') }}
              </td>
              <td class="py-3.5 px-4 font-mono text-[11px]">{{ tx.payment_method || 'Midtrans SNAP' }}</td>
              <td class="py-3.5 px-4">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold" :class="tx.payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'">
                  {{ tx.payment_status }}
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
  transactions: Array
});
</script>
