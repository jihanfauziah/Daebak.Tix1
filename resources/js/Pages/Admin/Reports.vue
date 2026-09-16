<template>
  <Layout title="Export Laporan Platform">
    <div class="space-y-6">
      <div class="card-daebak p-6 bg-white">
        <h3 class="font-heading text-lg text-daebak-charcoal mb-2">Export Laporan Penjualan & Transaksi</h3>
        <p class="text-xs text-daebak-charcoal/70 mb-6">Unduh laporan performa tiket, total penjualan, dan daftar user dalam format CSV / PDF.</p>

        <div class="grid sm:grid-cols-3 gap-4">
          <div class="p-5 rounded-2xl bg-daebak-cream/40 border border-daebak-sage/30 flex flex-col justify-between">
            <div>
              <span class="text-2xl">📊</span>
              <h4 class="font-heading text-base text-daebak-charcoal mt-2">Laporan Penjualan Bulanan</h4>
              <p class="text-[11px] text-daebak-charcoal/70 mt-1">Ringkasan transaksi paid per bulan</p>
            </div>
            <button @click="exportCSV('penjualan_bulanan')" class="btn-daebak-primary text-xs font-semibold py-2 px-4 mt-4">
              Export CSV 📥
            </button>
          </div>

          <div class="p-5 rounded-2xl bg-daebak-mint/40 border border-daebak-sage/30 flex flex-col justify-between">
            <div>
              <span class="text-2xl">🎟️</span>
              <h4 class="font-heading text-base text-daebak-charcoal mt-2">Laporan Tiket Terjual</h4>
              <p class="text-[11px] text-daebak-charcoal/70 mt-1">Status tiket valid vs scanned</p>
            </div>
            <button @click="exportCSV('tiket_terjual')" class="btn-daebak-primary text-xs font-semibold py-2 px-4 mt-4">
              Export CSV 📥
            </button>
          </div>

          <div class="p-5 rounded-2xl bg-daebak-coral/20 border border-daebak-sage/30 flex flex-col justify-between">
            <div>
              <span class="text-2xl">🏪</span>
              <h4 class="font-heading text-base text-daebak-charcoal mt-2">Laporan Mitra Penjual</h4>
              <p class="text-[11px] text-daebak-charcoal/70 mt-1">Status toko seller & langganan</p>
            </div>
            <button @click="exportCSV('mitra_penjual')" class="btn-daebak-primary text-xs font-semibold py-2 px-4 mt-4">
              Export CSV 📥
            </button>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

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
