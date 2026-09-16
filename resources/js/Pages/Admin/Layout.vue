<template>
  <DashboardLayout
    :title="title || 'Admin Console'"
    subtitle="Panel kontrol dan audit sistem Daebak.Tix"
    role-title="Administrator"
  >
    <template #nav>
      <NavLink href="/admin/dashboard" :active="isActive('/admin/dashboard')">
        <template #icon>📊</template>
        Dashboard
      </NavLink>
      <NavLink href="/admin/sellers" :active="isActive('/admin/sellers')">
        <template #icon>🏪</template>
        Verifikasi Promotor
      </NavLink>
      <NavLink href="/admin/buyers" :active="isActive('/admin/buyers')">
        <template #icon>👥</template>
        Data Pembeli
      </NavLink>
      <NavLink href="/admin/events" :active="isActive('/admin/events')">
        <template #icon>🎟️</template>
        Event & Tiket
      </NavLink>
      <NavLink href="/admin/transactions" :active="isActive('/admin/transactions')">
        <template #icon>💳</template>
        Transaksi
      </NavLink>
      <NavLink href="/admin/logs" :active="isActive('/admin/logs')">
        <template #icon>📜</template>
        Activity Logs
      </NavLink>
      <NavLink href="/admin/reports" :active="isActive('/admin/reports')">
        <template #icon>📈</template>
        Export Laporan
      </NavLink>
      <NavLink href="/admin/settings" :active="isActive('/admin/settings')">
        <template #icon>⚙️</template>
        Pengaturan
      </NavLink>
    </template>

    <template #topbar-actions>
      <Badge variant="coral">ADMINISTRATOR</Badge>
    </template>

    <slot />
  </DashboardLayout>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import DashboardLayout from '@/Components/DashboardLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import Badge from '@/Components/Badge.vue';

defineProps({
  title: {
    type: String,
    default: 'Admin Console'
  }
});

const page = usePage();

const isActive = (path) => {
  return page.url === path || (path !== '/admin/dashboard' && page.url.startsWith(path));
};
</script>
