<template>
  <Layout title="Buat Event Korea Baru" :profile="$page.props.auth.user?.seller_profile">
    <div class="max-w-3xl">
      <Card padding-class="p-8">
        <h2 class="font-heading text-2xl text-[#657166] mb-1">Formulir Tambah Event Baru</h2>
        <p class="text-xs text-[#657166]/70 mb-6">Isi detail event konser atau fanmeeting K-Pop secara lengkap dan akurat.</p>

        <form @submit.prevent="submit" class="space-y-5">
          <!-- Judul Event -->
          <TextInput
            id="event-title"
            label="Judul / Nama Event"
            type="text"
            v-model="form.title"
            required
            placeholder="BLACKPINK WORLD TOUR [BORN PINK] JAKARTA"
            :error="form.errors.title"
          />

          <div class="grid sm:grid-cols-2 gap-4">
            <!-- Kategori Event -->
            <div>
              <label class="block text-sm font-medium text-[#657166] mb-1.5 font-sans">Kategori Event</label>
              <select
                v-model="form.category"
                required
                class="w-full bg-white text-[#657166] border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans focus:outline-none focus:border-[#99CDD8]"
              >
                <option value="concert">Konser Idol (Concert)</option>
                <option value="fanmeeting">Fanmeeting / Fancon</option>
                <option value="cultural">Festival Budaya Korea</option>
                <option value="other">Lainnya</option>
              </select>
            </div>

            <!-- Tanggal Acara -->
            <TextInput
              id="event-date"
              label="Tanggal & Waktu Acara"
              type="datetime-local"
              v-model="form.event_date"
              required
              :error="form.errors.event_date"
            />
          </div>

          <!-- Lokasi -->
          <TextInput
            id="event-location"
            label="Lokasi Venue / Tempat Acara"
            type="text"
            v-model="form.location"
            required
            placeholder="Stadion Utama Gelora Bung Karno (GBK), Jakarta"
            :error="form.errors.location"
          />

          <!-- Deskripsi -->
          <div>
            <label class="block text-sm font-medium text-[#657166] mb-1.5 font-sans">Deskripsi Lengkap Event</label>
            <textarea
              v-model="form.description"
              required
              rows="3"
              placeholder="Jelaskan guest star, rincian benefit tiket, tata tertib, dan informasi promotor..."
              class="w-full bg-white text-[#657166] placeholder-[#657166]/40 border-[1.5px] border-[#CFD6C4] rounded-[8px] px-3.5 py-2.5 text-sm font-sans focus:outline-none focus:border-[#99CDD8] focus:ring-3 focus:ring-[#99CDD8]/25"
            ></textarea>
          </div>

          <!-- Banner Image URL -->
          <TextInput
            id="event-banner"
            label="URL Gambar Banner Event"
            type="text"
            v-model="form.banner_image"
            placeholder="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=800&q=80"
            :error="form.errors.banner_image"
          />

          <!-- Durasi Penjualan Awal (Fitur Akun Free & Paid) -->
          <div class="p-5 rounded-[18px] bg-[#DAEBE3]/40 border border-[#CFD6C4]/60 space-y-3">
            <label class="block text-xs font-bold text-[#657166] uppercase tracking-wider">Pilih Durasi Penjualan Awal Tiket</label>
            <div class="grid sm:grid-cols-2 gap-4">
              <label
                class="p-4 rounded-[14px] bg-white border cursor-pointer flex items-center justify-between transition-all"
                :class="form.initial_duration_days === 7 ? 'border-[#99CDD8] ring-2 ring-[#99CDD8]/40 shadow-xs' : 'border-[#CFD6C4]/60'"
              >
                <div class="flex items-center gap-3">
                  <input type="radio" v-model="form.initial_duration_days" :value="7" class="text-[#99CDD8]" />
                  <div>
                    <span class="font-bold text-sm block text-[#2D3A30]">7 Hari Penjualan</span>
                    <span class="text-[11px] text-[#657166]/70">Durasi awal event standar</span>
                  </div>
                </div>
              </label>

              <label
                class="p-4 rounded-[14px] bg-white border cursor-pointer flex items-center justify-between transition-all"
                :class="form.initial_duration_days === 12 ? 'border-[#99CDD8] ring-2 ring-[#99CDD8]/40 shadow-xs' : 'border-[#CFD6C4]/60'"
              >
                <div class="flex items-center gap-3">
                  <input type="radio" v-model="form.initial_duration_days" :value="12" class="text-[#99CDD8]" />
                  <div>
                    <span class="font-bold text-sm block text-[#2D3A30]">12 Hari Penjualan</span>
                    <span class="text-[11px] text-[#657166]/70">Durasi awal event extended</span>
                  </div>
                </div>
              </label>
            </div>
            <p class="text-[11px] text-[#657166]/75">
              ℹ️ 1 siklus penjualan tiket event = 15 hari. Promotor dapat memperpanjang 5 hari atau 7 hari saat masa aktif akan berakhir.
            </p>
          </div>

          <!-- Kategori Tiket & Kuota -->
          <div class="space-y-4 pt-2">
            <div class="flex items-center justify-between border-b border-[#CFD6C4]/40 pb-2">
              <h3 class="font-heading text-lg text-[#657166]">Kategori Tiket & Kuota Penjualan</h3>
              <button
                type="button"
                @click="addCategory"
                class="text-xs font-semibold text-[#2D3A30] hover:underline px-3 py-1 rounded-[10px] bg-[#DAEBE3]"
              >
                + Tambah Kategori
              </button>
            </div>

            <div
              v-for="(cat, index) in form.categories"
              :key="index"
              class="p-4 rounded-[16px] bg-[#FDE8D3]/25 border border-[#CFD6C4]/50 space-y-3"
            >
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-[#657166]">Kategori Tiket #{{ index + 1 }}</span>
                <button
                  v-if="form.categories.length > 1"
                  type="button"
                  @click="removeCategory(index)"
                  class="text-xs text-[#E76F51] hover:underline"
                >
                  Hapus
                </button>
              </div>
              <div class="grid sm:grid-cols-3 gap-3">
                <TextInput
                  :id="`cat-name-${index}`"
                  label="Nama Kategori"
                  type="text"
                  v-model="cat.name"
                  required
                  placeholder="VIP Soundcheck"
                />
                <TextInput
                  :id="`cat-price-${index}`"
                  label="Harga (Rp)"
                  type="number"
                  v-model="cat.price"
                  required
                  min="10000"
                  placeholder="2500000"
                />
                <TextInput
                  :id="`cat-quota-${index}`"
                  label="Kuota Tiket"
                  type="number"
                  v-model="cat.quota"
                  required
                  min="1"
                  placeholder="500"
                />
              </div>
            </div>
          </div>

          <div class="pt-4 border-t border-[#CFD6C4]/40 flex justify-end gap-3">
            <Link
              href="/seller/events"
              class="px-5 py-2.5 rounded-[16px] border border-[#CFD6C4] bg-white text-xs font-semibold text-[#657166] hover:bg-[#DAEBE3]/30 transition-colors"
            >
              Batal
            </Link>
            <PrimaryButton
              type="submit"
              :loading="form.processing"
              custom-class="text-xs font-semibold px-8 py-3 shadow-md"
            >
              Publikasikan Event 🚀
            </PrimaryButton>
          </div>
        </form>
      </Card>
    </div>
  </Layout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import Layout from '../Layout.vue';
import Card from '@/Components/Card.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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
