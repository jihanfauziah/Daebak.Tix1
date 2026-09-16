<template>
  <Layout title="Pengaturan Toko" :profile="$page.props.auth.user?.seller_profile">
    <div class="card-daebak p-8 bg-white max-w-xl">
      <h3 class="font-heading text-lg text-daebak-charcoal mb-4">Pengaturan Akun & Keamanan</h3>
      <p class="text-xs text-daebak-charcoal/70">Ubah password atau pengaturan preferensi toko Anda.</p>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
</script>
