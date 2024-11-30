<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipRegistration;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function index()
    {
        return view('scholarship.index');
    }

    public function create()
    {
        return view('scholarship.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email',
                    'phone' => 'required|numeric',
                    'semester' => 'required|integer|between:1,8',
                    'ipk' => 'required|numeric|between:0,4',
                    'scholarship_type' => 'required|in:akademik,non_akademik',
                    'document' => 'required|file|mimes:pdf,jpg,jpeg,zip|max:2048',
                ],
                [
                    'name.required' => 'Nama wajib diisi',
                    'name.string' => 'Nama harus berupa teks',
                    'name.max' => 'Nama maksimal 255 karakter',

                    'email.required' => 'Email wajib diisi',
                    'email.email' => 'Format email tidak valid',

                    'phone.required' => 'Nomor HP wajib diisi',
                    'phone.numeric' => 'Nomor HP harus berupa angka',

                    'semester.required' => 'Semester wajib dipilih',
                    'semester.integer' => 'Semester harus berupa angka',
                    'semester.between' => 'Semester harus antara 1-8',

                    'ipk.required' => 'IPK wajib diisi',
                    'ipk.numeric' => 'IPK harus berupa angka',
                    'ipk.between' => 'IPK harus antara 0-4',

                    'scholarship_type.required' => 'Jenis beasiswa wajib dipilih',
                    'scholarship_type.in' => 'Jenis beasiswa tidak valid',

                    'document.required' => 'Dokumen wajib diupload',
                    'document.file' => 'Upload file tidak valid',
                    'document.mimes' => 'Format file harus pdf, jpg, jpeg, atau zip',
                    'document.max' => 'Ukuran file maksimal 2MB',
                ],
            );

            if ($request->hasFile('document')) {
                $path = $request->file('document')->store('documents', 'public');

                ScholarshipRegistration::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'semester' => $request->semester,
                    'ipk' => $request->ipk,
                    'scholarship_type' => $request->scholarship_type,
                    'document_path' => $path,
                ]);

                return redirect()->route('scholarship.results')->with('success', 'Pendaftaran beasiswa berhasil dikirim!');
            }

            return back()->withInput()->with('error', 'Silakan upload dokumen persyaratan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function results()
    {
        try {
            $registrations = ScholarshipRegistration::latest()->get();

            // Hanya menyiapkan data untuk pie chart
            $chartData = [$registrations->where('scholarship_type', 'akademik')->count(), $registrations->where('scholarship_type', 'non_akademik')->count()];

            return view('scholarship.results', compact('registrations', 'chartData'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data hasil pendaftaran.');
        }
    }
}
