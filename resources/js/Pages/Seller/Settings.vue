<template>
  <Layout title="Pengaturan Toko" :profile="$page.props.auth.user?.seller_profile">
    <div class="max-w-xl">
      <Card padding-class="p-8">
        <h3 class="font-heading text-xl text-[#657166] mb-2">Pengaturan Akun & Keamanan</h3>
        <p class="text-xs text-[#657166]/70">Preferensi notifikasi dan konfigurasi operasional toko promotor.</p>
      </Card>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
</script>
