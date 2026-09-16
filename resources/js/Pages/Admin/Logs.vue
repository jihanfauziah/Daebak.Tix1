<template>
  <Layout title="Activity Logs Audit">
    <div class="card-daebak p-6 bg-white">
      <h3 class="font-heading text-lg text-daebak-charcoal mb-4">Log Aktivitas Pengguna (Semua Role)</h3>

      <div class="space-y-3">
        <div v-for="log in logs" :key="log.id" class="p-4 rounded-2xl bg-daebak-mint/20 border border-daebak-sage/30 flex items-center justify-between text-xs">
          <div class="space-y-1">
            <div class="flex items-center gap-2">
              <span class="font-bold text-daebak-charcoal">{{ log.user?.name || 'Sistem' }}</span>
              <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-daebak-coral text-white uppercase">{{ log.role || 'system' }}</span>
              <span class="text-daebak-charcoal/50 font-mono text-[11px]">IP: {{ log.ip_address || '127.0.0.1' }}</span>
            </div>
            <p class="text-daebak-charcoal/80 font-medium">{{ log.description }}</p>
          </div>
          <span class="text-[10px] text-daebak-charcoal/50 font-semibold">{{ new Date(log.created_at).toLocaleString('id-ID') }}</span>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';

defineProps({
  logs: Array
});
</script>
