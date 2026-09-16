<template>
  <Layout title="Manajemen Pembeli (Buyers)">
    <div class="card-daebak p-6 bg-white">
      <h3 class="font-heading text-lg text-daebak-charcoal mb-4">Daftar Akun Pembeli Terdaftar</h3>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead>
            <tr class="border-b border-daebak-sage/40 text-daebak-charcoal/60 uppercase">
              <th class="py-3 px-4">NIK</th>
              <th class="py-3 px-4">Nama Pembeli</th>
              <th class="py-3 px-4">Username & Email</th>
              <th class="py-3 px-4">Loyalty Points</th>
              <th class="py-3 px-4">Total Pesanan</th>
              <th class="py-3 px-4">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-daebak-sage/20">
            <tr v-for="buyer in buyers" :key="buyer.id">
              <td class="py-3.5 px-4 font-mono text-daebak-charcoal/80">{{ buyer.nik || '-' }}</td>
              <td class="py-3.5 px-4 font-semibold">{{ buyer.name }}</td>
              <td class="py-3.5 px-4">
                <div>@{{ buyer.username || 'buyer' }}</div>
                <span class="text-[10px] text-daebak-charcoal/60">{{ buyer.email }}</span>
              </td>
              <td class="py-3.5 px-4">
                <span class="font-bold text-daebak-coral">⭐ {{ buyer.loyalty_points }} Pts</span>
              </td>
              <td class="py-3.5 px-4 font-semibold">{{ buyer.orders_count }} Pesanan</td>
              <td class="py-3.5 px-4">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                  {{ buyer.status }}
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
  buyers: Array
});
</script>
