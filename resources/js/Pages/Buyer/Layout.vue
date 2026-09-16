<template>
  <DashboardLayout
    :title="pageTitle"
    :subtitle="pageSubtitle"
    role-title="Pembeli"
  >
    <template #nav>
      <NavLink href="/dashboard" :active="isActive('/dashboard')">
        <template #icon>🏠</template>
        Dashboard
      </NavLink>
      <NavLink href="/tickets" :active="isActive('/tickets')">
        <template #icon>🎫</template>
        Katalog Event
      </NavLink>
      <NavLink href="/my-tickets" :active="isActive('/my-tickets')">
        <template #icon>📲</template>
        Tiket Saya (QR)
      </NavLink>
      <NavLink href="/orders" :active="isActive('/orders')">
        <template #icon>📦</template>
        Riwayat Orders
      </NavLink>
      <NavLink href="/wishlist" :active="isActive('/wishlist')">
        <template #icon>❤️</template>
        Wishlist
      </NavLink>
      <NavLink href="/loyalty" :active="isActive('/loyalty')">
        <template #icon>⭐</template>
        Loyalty Points
      </NavLink>
      <NavLink href="/profile" :active="isActive('/profile')">
        <template #icon>👤</template>
        Profil Akun
      </NavLink>
    </template>

    <template #topbar-actions>
      <Link
        href="/loyalty"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[14px] bg-[#FDE8D3] border border-[#F3C3B2] text-xs font-semibold text-[#8C4E37]"
      >
        <span>⭐</span>
        <span>{{ $page.props.auth?.user?.loyalty_points || 0 }} Pts</span>
      </Link>
    </template>

    <slot />
  </DashboardLayout>
</template>

<script setup>
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import DashboardLayout from '@/Components/DashboardLayout.vue';
import NavLink from '@/Components/NavLink.vue';

const props = defineProps({
  title: {
    type: String,
    default: '',
  },
  subtitle: {
    type: String,
    default: '',
  },
});

const page = usePage();

const isActive = (path) => {
  return page.url === path || (path !== '/dashboard' && page.url.startsWith(path));
};

const pageTitle = computed(() => {
  if (props.title) return props.title;
  if (page.url.startsWith('/my-tickets')) return 'Tiket Digital Saya';
  if (page.url.startsWith('/tickets')) return 'Katalog Tiket Event';
  if (page.url.startsWith('/orders')) return 'Riwayat Pesanan';
  if (page.url.startsWith('/wishlist')) return 'Event Favorit / Wishlist';
  if (page.url.startsWith('/loyalty')) return 'Daebak Loyalty Points';
  if (page.url.startsWith('/profile')) return 'Profil Akun';
  return 'Dashboard Pembeli';
});

const pageSubtitle = computed(() => {
  if (props.subtitle) return props.subtitle;
  return 'Kelola tiket konser K-Pop, pesanan, dan loyalty reward.';
});
</script>
