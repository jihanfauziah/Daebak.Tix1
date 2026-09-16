<template>
  <Layout>
    <div class="max-w-2xl mx-auto space-y-6">
      <div class="card-daebak p-8 card-warm-gradient text-center space-y-4">
        <span class="text-4xl">⭐</span>
        <h1 class="font-heading text-3xl text-daebak-charcoal">Daebak.Tix Loyalty Points</h1>
        <p class="text-xs text-daebak-charcoal/80">Kumpulkan poin reward dari setiap pembelian tiket konser K-Pop!</p>
        
        <div class="p-4 rounded-2xl bg-white/90 backdrop-blur inline-block shadow-md">
          <span class="text-xs font-bold text-daebak-charcoal/60 uppercase block">Poin Reward Anda</span>
          <span class="font-heading text-4xl text-daebak-coral">{{ user.loyalty_points }} Pts</span>
        </div>
      </div>

      <div class="card-daebak p-6 bg-white space-y-4">
        <h3 class="font-heading text-lg text-daebak-charcoal">Cara Mendapatkan & Menukarkan Poin</h3>
        <ul class="space-y-3 text-xs text-daebak-charcoal/80">
          <li class="flex items-start gap-3">
            <span class="text-emerald-600 font-bold">1.</span>
            <span><strong>Pembelian Tiket:</strong> Dapatkan 1 poin setiap kelipatan transaksi Rp 10.000 di Daebak.Tix.</span>
          </li>
          <li class="flex items-start gap-3">
            <span class="text-emerald-600 font-bold">2.</span>
            <span><strong>Bonus Pendaftaran:</strong> Pengguna baru otomatis memperoleh 10 poin bonus gratis saat mendaftar.</span>
          </li>
          <li class="flex items-start gap-3">
            <span class="text-emerald-600 font-bold">3.</span>
            <span><strong>Tukarkan Voucher Diskons:</strong> Poin dapat ditukarkan dengan potongan harga tiket konser selanjutnya.</span>
          </li>
        </ul>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

defineProps({
  user: Object
});
</script>
