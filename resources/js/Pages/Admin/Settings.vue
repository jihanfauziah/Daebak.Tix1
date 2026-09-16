<template>
  <Layout title="Pengaturan Platform">
    <div class="max-w-2xl">
      <Card padding-class="p-8">
        <h3 class="font-heading text-xl text-[#657166] mb-5 border-b border-[#CFD6C4]/40 pb-3">Konfigurasi Gateway & Global Platform</h3>

        <div class="space-y-4 text-xs">
          <div>
            <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Nama Aplikasi Platform</label>
            <input type="text" value="Daebak.Tix Indonesia" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans text-[#657166]" readonly />
          </div>

          <div>
            <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Mode Midtrans Payment Gateway</label>
            <input type="text" value="Sandbox / Simulator (Mode Pengujian)" class="w-full bg-[#DAEBE3] border-[1.5px] border-[#DAEBE3] rounded-[8px] px-3.5 py-2.5 text-sm font-semibold text-[#1E4D38]" readonly />
          </div>

          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Midtrans Server Key</label>
              <input type="password" value="SB-Mid-server-DUMMYKEY123456" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-mono text-[#657166]" readonly />
            </div>
            <div>
              <label class="block font-semibold text-[#657166] mb-1.5 font-sans">Midtrans Client Key</label>
              <input type="password" value="SB-Mid-client-DUMMYKEY123456" class="w-full bg-[#DAEBE3]/20 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-mono text-[#657166]" readonly />
            </div>
          </div>

          <div class="pt-4 border-t border-[#CFD6C4]/40 flex justify-end">
            <PrimaryButton custom-class="text-xs font-semibold px-6 py-2.5">
              Simpan Pengaturan
            </PrimaryButton>
          </div>
        </div>
      </Card>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>
