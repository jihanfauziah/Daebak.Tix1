<template>
  <Layout title="Manajemen Data Pembeli">
    <Card padding-class="p-6">
      <h3 class="font-heading text-xl text-[#657166] mb-4">Daftar Akun Pembeli (1 NIK = 1 Akun)</h3>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead>
            <tr class="border-b border-[#CFD6C4]/50 text-[#657166]/70 uppercase">
              <th class="py-3 px-4 font-bold">NIK</th>
              <th class="py-3 px-4 font-bold">Nama Lengkap</th>
              <th class="py-3 px-4 font-bold">Username & Email</th>
              <th class="py-3 px-4 font-bold">Loyalty Points</th>
              <th class="py-3 px-4 font-bold">Total Transaksi</th>
              <th class="py-3 px-4 font-bold">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#CFD6C4]/30">
            <tr v-for="buyer in buyers" :key="buyer.id">
              <td class="py-3.5 px-4 font-mono font-semibold text-xs text-[#2D3A30]">{{ buyer.nik || '-' }}</td>
              <td class="py-3.5 px-4 font-semibold text-sm">{{ buyer.name }}</td>
              <td class="py-3.5 px-4">
                <div class="font-medium">@{{ buyer.username || 'buyer' }}</div>
                <span class="text-[11px] text-[#657166]/70">{{ buyer.email }}</span>
              </td>
              <td class="py-3.5 px-4">
                <Badge variant="coral">⭐ {{ buyer.loyalty_points }} Pts</Badge>
              </td>
              <td class="py-3.5 px-4 font-semibold text-[#2D3A30]">{{ buyer.orders_count }} Pesanan</td>
              <td class="py-3.5 px-4">
                <Badge variant="success" :dot="true">
                  {{ buyer.status }}
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
  buyers: {
    type: Array,
    default: () => []
  }
});
</script>
