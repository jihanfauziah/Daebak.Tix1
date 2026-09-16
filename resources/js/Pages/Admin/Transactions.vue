<template>
  <Layout title="Laporan Transaksi Pembelian">
    <Card padding-class="p-6">
      <h3 class="font-heading text-xl text-[#657166] mb-4">Riwayat Transaksi Penjualan & Pembelian Tiket</h3>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead>
            <tr class="border-b border-[#CFD6C4]/50 text-[#657166]/70 uppercase">
              <th class="py-3 px-4 font-bold">No. Order</th>
              <th class="py-3 px-4 font-bold">Pembeli</th>
              <th class="py-3 px-4 font-bold">Event & Promotor</th>
              <th class="py-3 px-4 font-bold">Total Tagihan</th>
              <th class="py-3 px-4 font-bold">Metode</th>
              <th class="py-3 px-4 font-bold">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#CFD6C4]/30">
            <tr v-for="tx in transactions" :key="tx.id">
              <td class="py-3.5 px-4 font-mono font-bold text-xs text-[#2D3A30]">{{ tx.order_number }}</td>
              <td class="py-3.5 px-4">
                <div class="font-semibold text-sm">{{ tx.buyer?.name || '-' }}</div>
                <span class="text-[11px] text-[#657166]/70">{{ tx.buyer?.email }}</span>
              </td>
              <td class="py-3.5 px-4">
                <div class="font-semibold text-[#657166]">{{ tx.event?.title || '-' }}</div>
                <span class="text-[11px] text-[#8C4E37] font-semibold">Toko: {{ tx.seller?.seller_profile?.store_name || '-' }}</span>
              </td>
              <td class="py-3.5 px-4 font-bold text-[#2D3A30] text-sm">
                Rp {{ Number(tx.total_amount).toLocaleString('id-ID') }}
              </td>
              <td class="py-3.5 px-4 font-mono text-[11px] text-[#657166]">{{ tx.payment_method || 'Midtrans SNAP' }}</td>
              <td class="py-3.5 px-4">
                <Badge :variant="tx.payment_status === 'paid' ? 'success' : 'warning'" :dot="true">
                  {{ tx.payment_status }}
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
  transactions: {
    type: Array,
    default: () => []
  }
});
</script>
