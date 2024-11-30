@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Tabel Section -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Hasil Pendaftaran Beasiswa</h2>
            </div>

            <div class="px-6 py-4">
                @include('components.alert')
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HP
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Semester</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IPK
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Beasiswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Berkas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status Ajuan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($registrations as $registration)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $registration->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $registration->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $registration->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $registration->semester }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $registration->ipk }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $registration->scholarship_type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($registration->document_path)
                                        <a href="{{ Storage::url($registration->document_path) }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-800">
                                            Lihat Berkas
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                            {{ $registration->status === 'belum di verifikasi' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $registration->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">Belum ada data pendaftaran
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Grafik Section --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-6 text-center">Distribusi Pendaftar Beasiswa</h3>
            <div class="max-w-lg mx-auto h-[300px]">
                <canvas id="scholarshipChart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const data = @json($chartData);

                new Chart(document.getElementById('scholarshipChart'), {
                    type: 'pie',
                    data: {
                        labels: ['Beasiswa Akademik', 'Beasiswa Non-Akademik'],
                        datasets: [{
                            data: data,
                            backgroundColor: [
                                '#3b82f6', // blue
                                '#60a5fa' // lighter blue
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${value} pendaftar (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
