<template>
  <Layout title="Buat Event Korea Baru" :profile="$page.props.auth.user?.seller_profile">
    <div class="card-daebak p-8 bg-white max-w-3xl">
      <h2 class="font-heading text-xl text-daebak-charcoal mb-2">Formulir Tambah Event Baru</h2>
      <p class="text-xs text-daebak-charcoal/70 mb-6">Isi detail event konser atau fanmeeting K-Pop secara lengkap.</p>

      <form @submit.prevent="submit" class="space-y-6">
        <!-- Judul Event -->
        <div>
          <label class="block text-xs font-semibold mb-1">Judul / Nama Event</label>
          <input type="text" v-model="form.title" required placeholder="BLACKPINK WORLD TOUR [BORN PINK] JAKARTA" class="w-full input-daebak text-sm" />
          <p v-if="form.errors.title" class="text-xs text-rose-600 mt-1">{{ form.errors.title }}</p>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
          <!-- Kategori Event -->
          <div>
            <label class="block text-xs font-semibold mb-1">Kategori Event</label>
            <select v-model="form.category" required class="w-full input-daebak text-sm bg-white">
              <option value="concert">Konser Idol (Concert)</option>
              <option value="fanmeeting">Fanmeeting / Fancon</option>
              <option value="cultural">Festival Budaya Korea</option>
              <option value="other">Lainnya</option>
            </select>
          </div>

          <!-- Tanggal Acara -->
          <div>
            <label class="block text-xs font-semibold mb-1">Tanggal & Waktu Pelaksanaan</label>
            <input type="datetime-local" v-model="form.event_date" required class="w-full input-daebak text-sm" />
          </div>
        </div>

        <!-- Lokasi -->
        <div>
          <label class="block text-xs font-semibold mb-1">Lokasi Venues / Tempat Acara</label>
          <input type="text" v-model="form.location" required placeholder="Stadion Utama Gelora Bung Karno (GBK), Jakarta" class="w-full input-daebak text-sm" />
        </div>

        <!-- Deskripsi -->
        <div>
          <label class="block text-xs font-semibold mb-1">Deskripsi Lengkap Event</label>
          <textarea v-model="form.description" required rows="3" placeholder="Jelaskan guest star, rincian benefit, dan peraturan acara..." class="w-full input-daebak text-sm"></textarea>
        </div>

        <!-- Banner Image URL -->
        <div>
          <label class="block text-xs font-semibold mb-1">URL Gambar Banner Event</label>
          <input type="text" v-model="form.banner_image" placeholder="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=800&q=80" class="w-full input-daebak text-sm" />
        </div>

        <!-- Durasi Penjualan Awal (Fitur Akun Free & Paid) -->
        <div class="p-5 rounded-2xl bg-daebak-mint/40 border border-daebak-sage/40 space-y-3">
          <label class="block text-xs font-bold text-daebak-charcoal uppercase">Pilih Durasi Penjualan Awal Tiket</label>
          <div class="grid sm:grid-cols-2 gap-4">
            <label class="p-4 rounded-xl bg-white border cursor-pointer flex items-center justify-between" :class="form.initial_duration_days === 7 ? 'border-daebak-coral ring-2 ring-daebak-coral/30' : 'border-daebak-sage/40'">
              <div class="flex items-center gap-3">
                <input type="radio" v-model="form.initial_duration_days" :value="7" />
                <div>
                  <span class="font-bold text-sm block">7 Hari Penjualan</span>
                  <span class="text-[11px] text-daebak-charcoal/70">Durasi awal event standar</span>
                </div>
              </div>
            </label>

            <label class="p-4 rounded-xl bg-white border cursor-pointer flex items-center justify-between" :class="form.initial_duration_days === 12 ? 'border-daebak-coral ring-2 ring-daebak-coral/30' : 'border-daebak-sage/40'">
              <div class="flex items-center gap-3">
                <input type="radio" v-model="form.initial_duration_days" :value="12" />
                <div>
                  <span class="font-bold text-sm block">12 Hari Penjualan</span>
                  <span class="text-[11px] text-daebak-charcoal/70">Durasi awal event extended</span>
                </div>
              </div>
            </label>
          </div>
          <p class="text-[11px] text-daebak-charcoal/70">
            ℹ️ 1 siklus penjualan tiket event = 15 hari. Seller dapat memperpanjang 5 hari atau 7 hari saat masa aktif akan berakhir.
          </p>
        </div>

        <!-- Kategori Tiket & Kuota -->
        <div class="space-y-4">
          <div class="flex items-center justify-between border-b border-daebak-sage/30 pb-2">
            <h3 class="font-heading text-base text-daebak-charcoal">Kategori Tiket & Harga</h3>
            <button type="button" @click="addCategory" class="text-xs font-semibold text-daebak-blue hover:underline">
              + Tambah Kategori
            </button>
          </div>

          <div v-for="(cat, index) in form.categories" :key="index" class="p-4 rounded-2xl bg-slate-50 border border-daebak-sage/30 space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold text-daebak-charcoal">Kategori #{{ index + 1 }}</span>
              <button v-if="form.categories.length > 1" type="button" @click="removeCategory(index)" class="text-xs text-rose-600 hover:underline">
                Hapus
              </button>
            </div>
            <div class="grid sm:grid-cols-3 gap-3">
              <div>
                <label class="block text-[11px] font-semibold mb-1">Nama Kategori</label>
                <input type="text" v-model="cat.name" required placeholder="VIP Soundcheck" class="w-full input-daebak text-xs" />
              </div>
              <div>
                <label class="block text-[11px] font-semibold mb-1">Harga (Rp)</label>
                <input type="number" v-model="cat.price" required min="10000" placeholder="2500000" class="w-full input-daebak text-xs" />
              </div>
              <div>
                <label class="block text-[11px] font-semibold mb-1">Kuota Tiket</label>
                <input type="number" v-model="cat.quota" required min="1" placeholder="500" class="w-full input-daebak text-xs" />
              </div>
            </div>
          </div>
        </div>

        <div class="pt-4 border-t border-daebak-sage/30 flex justify-end gap-3">
          <a href="/seller/events" class="px-5 py-2.5 rounded-xl border border-daebak-sage text-xs font-semibold">
            Batal
          </a>
          <button type="submit" :disabled="form.processing" class="btn-daebak-primary text-xs font-semibold px-8 py-3 shadow-md">
            <span v-if="form.processing">Memproses...</span>
            <span v-else>Publikasikan Event 🚀</span>
          </button>
        </div>
      </form>
    </div>
  </Layout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Layout from '../Layout.vue';

const form = useForm({
  title: '',
  category: 'concert',
  description: '',
  location: '',
  event_date: '',
  banner_image: '',
  initial_duration_days: 7,
  categories: [
    { name: 'VIP Soundcheck', price: 3800000, quota: 500 },
    { name: 'CAT 1 Festival', price: 2400000, quota: 1000 }
  ]
});

const addCategory = () => {
  form.categories.push({ name: 'CAT 2', price: 1500000, quota: 500 });
};

const removeCategory = (index) => {
  form.categories.splice(index, 1);
};

const submit = () => {
  form.post('/seller/events');
};
</script>
