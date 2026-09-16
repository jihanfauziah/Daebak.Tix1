<template>
  <Layout title="Pengaturan Platform Platform">
    <div class="card-daebak p-6 bg-white max-w-2xl">
      <h3 class="font-heading text-lg text-daebak-charcoal mb-4">Pengaturan Sistem & Payment Gateway</h3>

      <div class="space-y-5">
        <div>
          <label class="block text-xs font-semibold mb-1">Nama Aplikasi Platform</label>
          <input type="text" value="Daebak.Tix Indonesia" class="w-full input-daebak text-sm bg-slate-50" readonly />
        </div>

        <div>
          <label class="block text-xs font-semibold mb-1">Mode Midtrans Payment Gateway</label>
          <input type="text" value="Sandbox / Simulator (Mode Pengujian)" class="w-full input-daebak text-sm bg-emerald-50 text-emerald-900 font-semibold" readonly />
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-semibold mb-1">Midtrans Server Key</label>
            <input type="password" value="SB-Mid-server-DUMMYKEY123456" class="w-full input-daebak text-sm bg-slate-50" readonly />
          </div>
          <div>
            <label class="block text-xs font-semibold mb-1">Midtrans Client Key</label>
            <input type="password" value="SB-Mid-client-DUMMYKEY123456" class="w-full input-daebak text-sm bg-slate-50" readonly />
          </div>
        </div>

        <div class="pt-4 border-t border-daebak-sage/30 flex justify-end">
          <button class="btn-daebak-primary text-xs font-semibold px-6 py-2.5">
            Simpan Pengaturan
          </button>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
</script>
