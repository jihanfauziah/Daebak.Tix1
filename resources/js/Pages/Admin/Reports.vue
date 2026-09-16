<template>
  <Layout title="Export Laporan Platform">
    <div class="space-y-6">
      <Card padding-class="p-6">
        <h3 class="font-heading text-xl text-[#657166] mb-1">Export Data & Laporan Finansial</h3>
        <p class="text-xs text-[#657166]/70 mb-6">Unduh rekapan penjualan tiket, komisi platform, dan daftar mitra dalam format CSV.</p>

        <div class="grid sm:grid-cols-3 gap-6">
          <Card padding-class="p-6" custom-class="bg-[#FDE8D3]/30 border border-[#CFD6C4]/60 flex flex-col justify-between">
            <div>
              <span class="text-3xl block">📊</span>
              <h4 class="font-heading text-lg text-[#657166] mt-2">Laporan Penjualan Bulanan</h4>
              <p class="text-xs text-[#657166]/70 mt-1">Ringkasan transaksi status paid per bulan</p>
            </div>
            <div class="pt-4">
              <PrimaryButton @click="exportCSV('penjualan_bulanan')" custom-class="w-full text-xs py-2.5">
                Export CSV 📥
              </PrimaryButton>
            </div>
          </Card>

          <Card padding-class="p-6" custom-class="bg-[#DAEBE3]/35 border border-[#CFD6C4]/60 flex flex-col justify-between">
            <div>
              <span class="text-3xl block">🎟️</span>
              <h4 class="font-heading text-lg text-[#657166] mt-2">Laporan Tiket Terjual</h4>
              <p class="text-xs text-[#657166]/70 mt-1">Status tiket valid vs scanned di gate</p>
            </div>
            <div class="pt-4">
              <PrimaryButton @click="exportCSV('tiket_terjual')" custom-class="w-full text-xs py-2.5">
                Export CSV 📥
              </PrimaryButton>
            </div>
          </Card>

          <Card padding-class="p-6" custom-class="bg-[#F3C3B2]/25 border border-[#CFD6C4]/60 flex flex-col justify-between">
            <div>
              <span class="text-3xl block">🏪</span>
              <h4 class="font-heading text-lg text-[#657166] mt-2">Laporan Mitra Promotor</h4>
              <p class="text-xs text-[#657166]/70 mt-1">Status verifikasi seller & langganan</p>
            </div>
            <div class="pt-4">
              <PrimaryButton @click="exportCSV('mitra_penjual')" custom-class="w-full text-xs py-2.5">
                Export CSV 📥
              </PrimaryButton>
            </div>
          </Card>
        </div>
      </Card>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
  reports: Object
});

const exportCSV = (type) => {
  const dummyCSV = "ID,Tanggal,Kategori,Nominal,Status\n1,2026-09-16,K-Pop Concert,3800000,Paid\n2,2026-09-15,Fanmeeting,2900000,Paid";
  const blob = new Blob([dummyCSV], { type: 'text/csv' });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.setAttribute('href', url);
  a.setAttribute('download', `laporan_${type}_daebaktix.csv`);
  a.click();
};
</script>
