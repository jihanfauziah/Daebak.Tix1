<template>
  <Layout title="Profil Akun Saya" subtitle="Informasi identitas akun pembeli terdaftar (1 NIK = 1 Akun).">
    <div class="max-w-xl mx-auto">
      <Card padding-class="p-8">
        <h3 class="font-heading text-xl text-[#657166] border-b border-[#CFD6C4]/40 pb-3 mb-5">Data Identitas Pembeli</h3>

        <div class="space-y-4 text-xs">
          <div>
            <label class="block font-semibold text-[#657166] mb-1.5 font-sans">NIK (Nomor Induk Kependudukan)</label>
            <input type="text" :value="user.nik" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-mono text-[#657166]" readonly />
          </div>

          <div>
            <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Nama Lengkap (Sesuai KTP)</label>
            <input type="text" :value="user.name" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans text-[#657166]" readonly />
          </div>

          <div>
            <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Username & Email</label>
            <input type="text" :value="`@${user.username} (${user.email})`" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans text-[#657166]" readonly />
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Umur</label>
              <input type="text" :value="`${user.age} Tahun`" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans text-[#657166]" readonly />
            </div>
            <div>
              <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Jenis Kelamin</label>
              <input type="text" :value="user.gender === 'female' ? 'Perempuan' : 'Laki-laki'" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans text-[#657166]" readonly />
            </div>
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
  user: Object
});
</script>
