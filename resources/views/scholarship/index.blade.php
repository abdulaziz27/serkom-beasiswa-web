@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative h-[500px] bg-gray-900">
        <div class="absolute inset-0">
            {{-- https://placehold.co/1920x500 --}}
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="Students studying" class="w-full h-full object-cover opacity-50">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex flex-col justify-center h-full">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                    Wujudkan Mimpimu Melalui Beasiswa
                </h1>
                <p class="text-xl text-gray-200 mb-8 max-w-2xl">
                    Program beasiswa kami dirancang untuk mendukung mahasiswa berprestasi dalam mencapai potensi tertinggi mereka.
                </p>
                <div class="space-x-4">
                    <a href="{{ route('scholarship.create') }}"
                       class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Daftar Sekarang
                    </a>
                    <a href="#program"
                       class="inline-block bg-white text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Pelajari Program
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Program Section -->
    <div id="program" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Program Beasiswa</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Beasiswa Akademik -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="p-8">
                        <div class="mb-4">
                            <h3 class="text-2xl font-bold text-gray-900">Beasiswa Akademik</h3>
                            <div class="h-1 w-20 bg-blue-600 mt-2"></div>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Beasiswa yang diberikan kepada mahasiswa dengan prestasi akademik yang baik.
                        </p>
                        <ul class="space-y-3 text-gray-600 mb-8">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                IPK minimal 3.0
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Aktif berkuliah (semester 1-8)
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Melampirkan dokumen pendukung
                            </li>
                        </ul>
                        <a href="{{ route('scholarship.create') }}"
                           class="inline-block w-full text-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Daftar Beasiswa Akademik
                        </a>
                    </div>
                </div>

                <!-- Beasiswa Non-Akademik -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="p-8">
                        <div class="mb-4">
                            <h3 class="text-2xl font-bold text-gray-900">Beasiswa Non-Akademik</h3>
                            <div class="h-1 w-20 bg-blue-600 mt-2"></div>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Beasiswa yang diberikan kepada mahasiswa dengan prestasi non-akademik.
                        </p>
                        <ul class="space-y-3 text-gray-600 mb-8">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                IPK minimal 3.0
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Aktif berkuliah (semester 1-8)
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Memiliki prestasi non-akademik
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Melampirkan dokumen pendukung
                            </li>
                        </ul>
                        <a href="{{ route('scholarship.create') }}"
                           class="inline-block w-full text-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Daftar Beasiswa Non-Akademik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
