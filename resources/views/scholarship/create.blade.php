@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-8 pb-2 border-b">Registrasi Beasiswa</h2>

        @include('components.alert')

        <form action="{{ route('scholarship.store') }}" method="POST" enctype="multipart/form-data" id="scholarshipForm">
            @csrf
            <div class="space-y-6">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masukkan Nama</label>
                    <input type="text" name="name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masukkan Email</label>
                    <input type="email" name="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>

                <!-- Nomor HP -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                    <input type="tel" name="phone" required pattern="[0-9]*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>

                <!-- Semester -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Semester saat ini</label>
                    <select name="semester" id="semester" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">Pilih</option>
                        @for ($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <!-- IPK -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">IPK terakhir</label>
                    <input type="text" id="ipk" name="ipk" readonly
                        class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
                </div>

                <!-- Jenis Beasiswa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Beasiswa</label>
                    <select name="scholarship_type" id="scholarshipType" required disabled
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">Pilihan Beasiswa</option>
                        <option value="akademik">Beasiswa Akademik</option>
                        <option value="non_akademik">Beasiswa Non-Akademik</option>
                    </select>
                </div>

                <!-- Upload Berkas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Berkas Syarat</label>
                    <input type="file" name="document" id="document" required disabled
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                        accept=".pdf,.jpg,.jpeg,.zip">
                    <p class="mt-1 text-sm text-gray-500">Upload file dalam format PDF, JPG, atau ZIP (max 2MB)</p>
                </div>

                <!-- Buttons -->
                <div class="flex justify-center space-x-6 pt-6">
                    <button type="submit" id="submitBtn" disabled
                        class="w-32 bg-blue-500 text-white px-4 py-2.5 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50">
                        Daftar
                    </button>
                    <a href="{{ route('scholarship.index') }}"
                        class="w-32 bg-gray-500 text-white px-4 py-2.5 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                /**
                 * Mendapatkan referensi ke elemen-elemen form yang dibutuhkan
                 * untuk validasi dan manipulasi state form beasiswa
                 */
                const form = document.getElementById('scholarshipForm');
                const semesterSelect = document.getElementById('semester');
                const ipkInput = document.getElementById('ipk');
                const scholarshipType = document.getElementById('scholarshipType');
                const documentInput = document.getElementById('document');
                const submitBtn = document.getElementById('submitBtn');

                /**
                 * Array berisi nilai IPK yang telah ditentukan untuk setiap semester
                 * Index array (0-7) merepresentasikan semester 1-8
                 * Nilai IPK dalam skala 0.0 - 4.0
                 */
                const ipkArray = [
                    3.4,
                    2.9,
                    3.5,
                    3.2,
                    1.8,
                    2.2,
                    3.8,
                    3.6
                ];

                /**
                 * Mengambil nilai IPK berdasarkan semester yang dipilih
                 * @param {number} semester - Nomor semester (1-8)
                 * @returns {number} Nilai IPK untuk semester yang dipilih
                 */
                function getIPKBySemester(semester) {
                    return ipkArray[semester - 1];
                }

                /**
                 * Memperbarui state form berdasarkan nilai IPK
                 * Mengaktifkan/menonaktifkan elemen form sesuai dengan
                 * persyaratan minimal IPK >= 3.0
                 * @param {number} ipk - Nilai IPK mahasiswa
                 */
                function updateFormState(ipk) {
                    const ipkValue = parseFloat(ipk);
                    const isEligible = ipkValue >= 3.0;

                    // Update status aktif/nonaktif elemen form
                    scholarshipType.disabled = !isEligible;
                    documentInput.disabled = !isEligible;
                    submitBtn.disabled = !isEligible;

                    // Tampilkan pesan jika tidak memenuhi syarat
                    if (!isEligible) {
                        setTimeout(() => {
                            alert(
                                'Maaf, IPK Anda di bawah 3.0 dan tidak memenuhi syarat untuk mendaftar beasiswa.'
                            );
                        }, 100);
                    }
                }

                /**
                 * Event Handler for Semester Selection
                 * Menangani perubahan pada pilihan semester
                 * Mengupdate nilai IPK dan state form secara otomatis
                 */
                semesterSelect.addEventListener('change', function() {
                    if (this.value) {
                        const selectedSemester = parseInt(this.value);
                        const ipk = getIPKBySemester(selectedSemester);
                        ipkInput.value = ipk.toFixed(2); // Format IPK ke 2 desimal
                        updateFormState(ipk);
                    } else {
                        // Reset form state jika tidak ada semester yang dipilih
                        ipkInput.value = '';
                        updateFormState(0);
                    }
                });
            });
        </script>
    @endpush
@endsection
