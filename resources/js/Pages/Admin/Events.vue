<template>
  <Layout title="Manajemen Seluruh Event Platform">
    <div class="space-y-6">
      <Card padding-class="p-6">
        <h3 class="font-heading text-xl text-[#657166] mb-4">Daftar Seluruh Event Korea dari Semua Promotor</h3>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <Card
            v-for="event in events"
            :key="event.id"
            padding-class="p-5"
            custom-class="flex flex-col justify-between"
          >
            <div class="space-y-3">
              <div class="relative h-40 rounded-[16px] overflow-hidden bg-[#DAEBE3]/40">
                <img :src="event.banner_image" :alt="event.title" class="w-full h-full object-cover" />
                <div class="absolute top-2 right-2">
                  <Badge variant="coral">{{ event.category }}</Badge>
                </div>
              </div>
              <div>
                <span class="text-[10px] font-bold text-[#8C4E37] uppercase tracking-wider">
                  Promotor: {{ event.seller?.seller_profile?.store_name || event.seller?.name }}
                </span>
                <h4 class="font-heading text-base text-[#657166] mt-1 line-clamp-2 leading-snug">{{ event.title }}</h4>
                <p class="text-xs text-[#657166]/70 mt-1">📍 {{ event.location }}</p>
              </div>
            </div>

            <div class="pt-4 border-t border-[#CFD6C4]/30 mt-4 flex items-center justify-between text-xs">
              <div>
                <span class="text-[10px] text-[#657166]/60">Kategori Tiket</span>
                <p class="font-bold text-[#2D3A30]">{{ event.categories?.length || 0 }} Kategori</p>
              </div>
              <Badge :variant="event.status === 'active' ? 'success' : 'danger'" :dot="true">
                {{ event.status }}
              </Badge>
            </div>
          </Card>
        </div>
      </Card>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';

defineProps({
  events: {
    type: Array,
    default: () => []
  }
});
</script>
