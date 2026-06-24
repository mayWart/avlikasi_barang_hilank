<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Postingan Kehilangan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('posts.store') }}" method="POST" id="postForm">
                        @csrf

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 mb-2">Jenis Informasi</label>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <label class="flex items-center gap-2 cursor-pointer bg-red-50 text-red-700 px-4 py-2 border border-red-200 rounded-md hover:bg-red-100 transition">
                                    <input type="radio" name="type" value="lost" checked class="text-red-600 focus:ring-red-500">
                                    <span class="font-medium text-sm">Saya Kehilangan Barang</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer bg-blue-50 text-blue-700 px-4 py-2 border border-blue-200 rounded-md hover:bg-blue-100 transition">
                                    <input type="radio" name="type" value="found" class="text-blue-600 focus:ring-blue-500">
                                    <span class="font-medium text-sm">Saya Menemukan Barang</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 mb-1">Kategori Barang</label>
                            <select name="category" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Pilih Kategori...</option>
                                <option value="Dompet & Tas">Dompet & Tas</option>
                                <option value="KTP & Dokumen">KTP & Dokumen</option>
                                <option value="Kunci">Kunci</option>
                                <option value="Elektronik (HP/Laptop)">Elektronik (HP/Laptop)</option>
                                <option value="Kendaraan">Kendaraan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 mb-1">Nama Barang</label>
                            <input type="text" name="item_name" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Contoh: Kunci Motor Honda, KTP atas nama Budi..." required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 mb-1">Deskripsi & Lokasi</label>
                            <textarea name="description" rows="4" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Ceritakan ciri-ciri barang dan lokasi terakhir terlihat atau ditemukan..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 mb-1">Upload Gambar Barang (Maks 2MB)</label>
                            
                            <input type="file" id="imageInput" class="w-full border border-gray-300 rounded-md p-2 text-sm bg-gray-50 focus:outline-none" accept="image/*" required>
                            
                            <div id="loadingIndicator" class="hidden flex items-center mt-3 text-blue-600">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-sm font-medium">Mengunggah ke Cloudinary... Tunggu sebentar.</span>
                            </div>

                            <div id="successIndicator" class="hidden mt-3">
                                <span class="text-sm font-medium text-green-600 mb-2 block">✅ Upload Berhasil!</span>
                                <img id="imagePreview" src="" class="h-40 w-auto rounded border shadow-sm object-cover">
                            </div>

                            <div id="errorIndicator" class="hidden mt-3 p-3 bg-red-50 border border-red-200 rounded text-sm font-medium text-red-600">
                            </div>

                            <input type="hidden" name="image_url" id="imageUrlInput">
                        </div>

                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700 mb-1">Nomor WhatsApp Aktif</label>
                            <input type="text" name="wa_number" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Contoh: 081234567890" required>
                        </div>

                        <div class="flex justify-end gap-3 border-t pt-4 mt-2">
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md font-medium hover:bg-gray-200 transition">Batal</a>
                            <button type="submit" id="submitBtn" class="px-4 py-2 bg-gray-400 text-white rounded-md font-medium cursor-not-allowed transition" disabled>
                                Upload Postingan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('imageInput').addEventListener('change', async function() {
            const file = this.files[0];
            if (!file) return;

            const loading = document.getElementById('loadingIndicator');
            const success = document.getElementById('successIndicator');
            const error = document.getElementById('errorIndicator');
            const preview = document.getElementById('imagePreview');
            const hiddenInput = document.getElementById('imageUrlInput');
            const submitBtn = document.getElementById('submitBtn');
            const csrfToken = document.querySelector('input[name="_token"]').value;

            // Reset state
            success.classList.add('hidden');
            error.classList.add('hidden');
            submitBtn.disabled = true;
            submitBtn.classList.replace('bg-blue-600', 'bg-gray-400');
            submitBtn.classList.add('cursor-not-allowed');
            loading.classList.remove('hidden');

            const formData = new FormData();
            formData.append('image', file);

            try {
                const response = await fetch("{{ route('posts.uploadImage') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: formData
                });

                // Ambil response sebagai teks murni dulu untuk mencegah error JSON Parse
                const textResponse = await response.text(); 
                let data;

                try {
                    data = JSON.parse(textResponse);
                } catch (parseError) {
                    throw new Error("Server mengembalikan error sistem (Bukan JSON). Buka tab Network di Inspect Element untuk melihat detail HTML.");
                }

                if (response.ok && data.success) {
                    hiddenInput.value = data.url; 
                    preview.src = data.url; 
                    loading.classList.add('hidden');
                    success.classList.remove('hidden');
                    
                    submitBtn.disabled = false;
                    submitBtn.classList.replace('bg-gray-400', 'bg-blue-600');
                    submitBtn.classList.remove('cursor-not-allowed');
                } else {
                    let errorMessage = data.message || 'Terjadi kesalahan server.';
                    if (data.errors) errorMessage = Object.values(data.errors)[0][0];
                    throw new Error(errorMessage);
                }
            } catch (err) {
                loading.classList.add('hidden');
                error.classList.remove('hidden');
                error.innerText = err.message; 
                this.value = ''; 
            }
        });
    </script>
</x-app-layout>