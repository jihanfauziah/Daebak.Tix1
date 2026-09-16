<template>
  <Layout title="Loyalty Reward Points" subtitle="Kumpulkan poin dari setiap transaksi dan tukarkan dengan voucher diskon.">
    <div class="max-w-2xl mx-auto space-y-6">
      <Card padding-class="p-8" custom-class="text-center space-y-4 bg-gradient-to-br from-[#FDE8D3] via-white to-[#F3C3B2]/30 border border-[#CFD6C4]/60">
        <span class="text-4xl block">⭐</span>
        <h1 class="font-heading text-3xl text-[#657166]">Daebak Loyalty Points</h1>
        <p class="text-xs text-[#657166]/80">Kumpulkan poin reward dari setiap pembelian tiket konser K-Pop!</p>
        
        <div class="p-4 rounded-[18px] bg-white border border-[#CFD6C4]/50 inline-block shadow-xs">
          <span class="text-xs font-bold text-[#657166]/70 uppercase block tracking-wider">Poin Tersedia</span>
          <span class="font-heading text-4xl text-[#8C4E37]">{{ user?.loyalty_points || 0 }} Pts</span>
        </div>
      </Card>

      <Card padding-class="p-6" custom-class="space-y-4">
        <h3 class="font-heading text-xl text-[#657166]">Ketentuan Reward Points</h3>
        <ul class="space-y-3 text-xs text-[#657166]/85">
          <li class="flex items-start gap-3">
            <span class="w-5 h-5 rounded-full bg-[#DAEBE3] text-[#1E4D38] flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">1</span>
            <span><strong>Transaksi Tiket:</strong> Dapatkan 1 poin untuk setiap transaksi Rp 10.000 di Daebak.Tix.</span>
          </li>
          <li class="flex items-start gap-3">
            <span class="w-5 h-5 rounded-full bg-[#DAEBE3] text-[#1E4D38] flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">2</span>
            <span><strong>Bonus Akun Baru:</strong> Pengguna baru otomatis memperoleh 10 poin bonus saat mendaftar.</span>
          </li>
          <li class="flex items-start gap-3">
            <span class="w-5 h-5 rounded-full bg-[#DAEBE3] text-[#1E4D38] flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">3</span>
            <span><strong>Potongan Harga:</strong> Poin dapat digunakan sebagai potongan langsung pada transaksi event berikutnya.</span>
          </li>
        </ul>
      </Card>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';

defineProps({
  user: Object
});
</script>
