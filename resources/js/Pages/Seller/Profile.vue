<template>
  <Layout title="Profil Toko Promotor" :profile="profile">
    <div class="max-w-2xl">
      <Card padding-class="p-8">
        <h3 class="font-heading text-xl text-[#657166] mb-5 border-b border-[#CFD6C4]/40 pb-3">Informasi Legal Toko Promotor</h3>

        <div class="space-y-4 text-xs">
          <div>
            <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Nama Toko Promotor</label>
            <input type="text" :value="profile?.store_name" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans text-[#657166]" readonly />
          </div>

          <div>
            <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Email Resmi Toko</label>
            <input type="text" :value="profile?.store_email" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-mono text-[#657166]" readonly />
          </div>

          <div>
            <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Kode Akun Unik Toko</label>
            <input type="text" :value="profile?.account_code" class="w-full bg-[#FDE8D3]/40 border-[1.5px] border-[#F3C3B2] rounded-[8px] px-3.5 py-2.5 text-sm font-mono font-bold text-[#8C4E37]" readonly />
          </div>

          <div>
            <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Deskripsi Promotor</label>
            <textarea :value="profile?.store_description" rows="3" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans text-[#657166]" readonly></textarea>
          </div>

          <div>
            <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Alamat Kantor</label>
            <input type="text" :value="profile?.store_address" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans text-[#657166]" readonly />
          </div>
        </div>
      </Card>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';

defineProps({
  profile: Object
});
</script>
