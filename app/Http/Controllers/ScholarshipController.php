<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipRegistration;
use Illuminate\Support\Facades\Validator;
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

    /**
     * Custom validation rules untuk pendaftaran beasiswa
     */
    private $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:scholarship_registrations',
        'phone' => [
            'required',
            'numeric',
            'regex:/^[0-9]{10,13}$/' // Memastikan nomor HP 10-13 digit
        ],
        'semester' => 'required|integer|between:1,8',
        'ipk' => 'required|numeric|between:0,4',
        'scholarship_type' => 'required|in:akademik,non_akademik',
        'document' => 'required|file|mimes:pdf,jpg,jpeg,zip|max:2048'
    ];

    /**
     * Custom error messages untuk validasi
     */
    private $messages = [
        'name.required' => 'Nama wajib diisi',
        'name.string' => 'Nama harus berupa teks',
        'name.max' => 'Nama maksimal 255 karakter',

        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',

        'phone.required' => 'Nomor HP wajib diisi',
        'phone.numeric' => 'Nomor HP harus berupa angka',
        'phone.regex' => 'Nomor HP harus 10-13 digit',

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
        'document.max' => 'Ukuran file maksimal 2MB'
    ];

    public function store(Request $request)
    {
        try {
            // Membuat validator
            $validator = Validator::make($request->all(), $this->rules, $this->messages);

            // Cek jika validasi gagal
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Jika validasi berhasil, proses data
            if ($request->hasFile('document')) {
                $path = $request->file('document')->store('documents', 'public');

                // Buat record baru
                ScholarshipRegistration::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'semester' => $request->semester,
                    'ipk' => $request->ipk,
                    'scholarship_type' => $request->scholarship_type,
                    'document_path' => $path
                ]);

                return redirect()
                    ->route('scholarship.results')
                    ->with('success', 'Pendaftaran beasiswa berhasil dikirim!');
            }

            return back()
                ->withInput()
                ->with('error', 'Silakan upload dokumen persyaratan.');
        } catch (\Exception $e) {
            \Log::error('Scholarship registration error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pendaftaran.');
        }
    }

    /**
     * Custom validation untuk cek format nomor HP
     */
    private function validatePhoneNumber($number)
    {
        return preg_match('/^[0-9]{10,13}$/', $number);
    }

    // Menampilkan hasil pendaftaran beasiswa
    public function results()
    {
        try {
            // Ambil data registrasi
            $registrations = ScholarshipRegistration::latest()->get();

            // menyiapkan data untuk pie chart
            $chartData = [$registrations->where('scholarship_type', 'akademik')->count(), $registrations->where('scholarship_type', 'non_akademik')->count()];

            return view('scholarship.results', compact('registrations', 'chartData'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data hasil pendaftaran.');
        }
    }
}
