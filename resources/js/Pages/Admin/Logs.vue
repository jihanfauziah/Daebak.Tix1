<template>
  <Layout title="Activity Logs Audit">
    <Card padding-class="p-6">
      <h3 class="font-heading text-xl text-[#657166] mb-4">Log Audit Aktivitas Pengguna (Semua Role)</h3>

      <div class="space-y-3">
        <div
          v-for="log in logs"
          :key="log.id"
          class="p-4 rounded-[16px] bg-[#DAEBE3]/25 border border-[#CFD6C4]/40 flex items-center justify-between text-xs"
        >
          <div class="space-y-1">
            <div class="flex items-center gap-2">
              <span class="font-bold text-sm text-[#2D3A30]">{{ log.user?.name || 'Sistem' }}</span>
              <Badge variant="coral">{{ log.role || 'system' }}</Badge>
              <span class="text-[#657166]/60 font-mono text-[11px]">IP: {{ log.ip_address || '127.0.0.1' }}</span>
            </div>
            <p class="text-[#657166] font-medium">{{ log.description }}</p>
          </div>
          <span class="text-[11px] text-[#657166]/60 font-semibold">{{ new Date(log.created_at).toLocaleString('id-ID') }}</span>
        </div>
      </div>
    </Card>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';

defineProps({
  logs: {
    type: Array,
    default: () => []
  }
});
</script>
