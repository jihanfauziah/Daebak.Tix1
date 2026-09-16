<template>
  <Layout title="Profil Toko Seller" :profile="profile">
    <div class="card-daebak p-8 bg-white max-w-2xl">
      <h3 class="font-heading text-xl text-daebak-charcoal mb-4">Informasi Profil Toko Promotor</h3>

      <div class="space-y-4 text-xs">
        <div>
          <label class="block font-semibold text-daebak-charcoal/70 mb-1">Nama Toko</label>
          <input type="text" :value="profile?.store_name" class="w-full input-daebak text-sm bg-slate-50" readonly />
        </div>

        <div>
          <label class="block font-semibold text-daebak-charcoal/70 mb-1">Email Toko</label>
          <input type="text" :value="profile?.store_email" class="w-full input-daebak text-sm bg-slate-50 font-mono" readonly />
        </div>

        <div>
          <label class="block font-semibold text-daebak-charcoal/70 mb-1">Kode Akun Unik</label>
          <input type="text" :value="profile?.account_code" class="w-full input-daebak text-sm bg-daebak-mint/30 font-mono font-bold text-daebak-charcoal" readonly />
        </div>

        <div>
          <label class="block font-semibold text-daebak-charcoal/70 mb-1">Deskripsi Toko</label>
          <textarea :value="profile?.store_description" rows="3" class="w-full input-daebak text-sm bg-slate-50" readonly></textarea>
        </div>

        <div>
          <label class="block font-semibold text-daebak-charcoal/70 mb-1">Alamat Kantor / Toko</label>
          <input type="text" :value="profile?.store_address" class="w-full input-daebak text-sm bg-slate-50" readonly />
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

defineProps({
  profile: Object
});
</script>
