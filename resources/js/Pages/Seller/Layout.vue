<template>
  <DashboardLayout
    :title="title || 'Dashboard Seller'"
    :subtitle="`Toko: ${profile?.store_name || 'Promotor Resmi'} (CODE: ${profile?.account_code || 'SELLER'})`"
    role-title="Promotor"
  >
    <template #nav>
      <NavLink href="/seller/dashboard" :active="isActive('/seller/dashboard')">
        <template #icon>📈</template>
        Dashboard
      </NavLink>
      <NavLink href="/seller/events" :active="isActive('/seller/events') && !isActive('/seller/events/create')">
        <template #icon>🎟️</template>
        My Event
      </NavLink>
      <NavLink href="/seller/events/create" :active="isActive('/seller/events/create')">
        <template #icon>➕</template>
        Buat Event Baru
      </NavLink>
      <NavLink href="/seller/subscription" :active="isActive('/seller/subscription')">
        <template #icon>👑</template>
        Paket Langganan
      </NavLink>
      <NavLink href="/seller/staff" :active="isActive('/seller/staff')">
        <template #icon>👥</template>
        Akun Staf Gate (PWA)
      </NavLink>
      <NavLink href="/seller/orders" :active="isActive('/seller/orders')">
        <template #icon>📦</template>
        Orders Masuk
      </NavLink>
      <NavLink href="/seller/profile" :active="isActive('/seller/profile')">
        <template #icon>👤</template>
        Profil Toko
      </NavLink>
    </template>

    <template #topbar-actions>
      <Badge variant="coral">
        {{ profile?.account_code || 'SELLER' }}
      </Badge>
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
    default: 'Dashboard Seller',
  },
  profile: {
    type: Object,
    default: () => ({}),
  },
});

const page = usePage();

const isActive = (path) => {
  return page.url === path || (path !== '/seller/dashboard' && page.url.startsWith(path));
};
</script>
