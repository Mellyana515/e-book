@extends('layouts.app')

@section('title', 'Verifikasi 2 Langkah')
@section('hide_newsletter', true)
@section('hide_navbar', true)

@section('content')
<div style="min-height: calc(100vh - 200px); background: linear-gradient(180deg, #f7f9ff 0%, #eef3ff 100%); display: flex; align-items: center; padding: 40px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div style="background:#fff; border-radius:28px; overflow:hidden; box-shadow:0 24px 60px rgba(60, 90, 170, .12); border:1px solid #edf2ff;">
                    <div class="row g-0">
                        <div class="col-lg-6 d-none d-lg-block" style="background:linear-gradient(180deg, #edf3ff 0%, #dfe9ff 100%); position:relative; min-height:720px;">
                            <div style="position:absolute; inset:0; padding:22px;">
                                <div style="height:100%; border-radius:24px; overflow:hidden; position:relative; background:linear-gradient(180deg, rgba(255,255,255,.38) 0%, rgba(202,218,255,.45) 100%);">
                                    <img src="{{ asset('login-illustration.png') }}" alt="Ilustrasi membaca buku" style="width:100%; height:100%; object-fit:cover; object-position:center;">

                                    <div style="position:absolute; left:24px; right:24px; bottom:24px; background:rgba(255,255,255,.78); backdrop-filter:blur(14px); border:1px solid rgba(255,255,255,.75); border-radius:22px; padding:22px 24px; box-shadow:0 16px 30px rgba(102,126,234,.12);">
                                        <div style="font-size:2rem; color:#2f6fed; margin-bottom:8px;">
                                            <i class="bi bi-shield-check"></i>
                                        </div>
                                        <h3 style="font-size:1.8rem; font-weight:800; color:#1e293b; margin-bottom:8px; font-family:'Nunito', sans-serif;">
                                            Verifikasi akun Anda
                                        </h3>
                                        <p style="font-size:1rem; color:#64748b; line-height:1.7; margin-bottom:18px;">
                                            Masukkan kode OTP agar proses login tetap aman dan akun Anda terlindungi.
                                        </p>
                                        <div class="row text-center g-3">
                                            <div class="col-4">
                                                <div style="width:52px; height:52px; margin:0 auto 8px; border-radius:16px; background:#edf3ff; color:#2f6fed; display:flex; align-items:center; justify-content:center; font-size:1.3rem;">
                                                    <i class="bi bi-envelope-paper"></i>
                                                </div>
                                                <div style="font-size:.82rem; color:#475569; font-weight:700;">Kode email</div>
                                            </div>
                                            <div class="col-4">
                                                <div style="width:52px; height:52px; margin:0 auto 8px; border-radius:16px; background:#edf3ff; color:#2f6fed; display:flex; align-items:center; justify-content:center; font-size:1.3rem;">
                                                    <i class="bi bi-clock-history"></i>
                                                </div>
                                                <div style="font-size:.82rem; color:#475569; font-weight:700;">10 menit</div>
                                            </div>
                                            <div class="col-4">
                                                <div style="width:52px; height:52px; margin:0 auto 8px; border-radius:16px; background:#edf3ff; color:#2f6fed; display:flex; align-items:center; justify-content:center; font-size:1.3rem;">
                                                    <i class="bi bi-lock"></i>
                                                </div>
                                                <div style="font-size:.82rem; color:#475569; font-weight:700;">Aman</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6" style="display:flex; align-items:center; min-height:720px;">
                            <div style="width:100%; max-width:460px; margin:0 auto; padding:40px 28px;">
                                <div class="d-flex align-items-center gap-2 mb-4">
                                    <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:10px; text-decoration:none;">
                                        <span style="width:42px; height:42px; border-radius:14px; background:linear-gradient(135deg,#4f8cff 0%, #2f6fed 100%); color:#fff; display:flex; align-items:center; justify-content:center; box-shadow:0 10px 24px rgba(47,111,237,.22);">
                                            <i class="bi bi-book"></i>
                                        </span>
                                        <span style="font-size:1.55rem; font-weight:800; color:#1e293b; font-family:'Nunito', sans-serif;">EBook</span>
                                    </a>
                                </div>

                                <div style="margin-bottom:28px;">
                                    <h1 style="font-size:2.4rem; line-height:1.15; font-weight:900; color:#1e293b; margin-bottom:10px; font-family:'Nunito', sans-serif;">
                                        Verifikasi 2 Langkah
                                    </h1>
                                    <p style="font-size:1rem; color:#64748b; line-height:1.8; margin-bottom:0;">
                                        Masukkan kode 6 digit yang kami kirim ke
                                        <strong style="color:#334155;">{{ $email }}</strong>.
                                    </p>
                                </div>

                                <form action="{{ route('two-factor.verify') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="code" style="font-weight:800; font-size:0.92rem; color:#334155; display:block; margin-bottom:10px;">Kode Verifikasi</label>
                                        <div style="position:relative;">
                                            <i class="bi bi-shield-lock" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                                            <input
                                                type="text"
                                                id="code"
                                                name="code"
                                                value="{{ old('code') }}"
                                                placeholder="Masukkan 6 digit kode"
                                                autofocus
                                                required
                                                inputmode="numeric"
                                                maxlength="6"
                                                autocomplete="one-time-code"
                                                class="@error('code') is-invalid @enderror"
                                                style="width:100%; padding:15px 18px 15px 46px; border:1.5px solid #e2e8f0; border-radius:14px; font-size:1rem; letter-spacing:8px; outline:none; background:#fff; transition:border .2s, box-shadow .2s;"
                                                onfocus="this.style.borderColor='#2f6fed';this.style.boxShadow='0 0 0 4px rgba(47,111,237,.10)'"
                                                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                                        </div>
                                        @error('code')
                                            <div class="invalid-feedback d-block" style="margin-top:8px;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                        <div style="display:flex; align-items:center; gap:8px; color:#64748b; font-size:.92rem;">
                                            <i class="bi bi-clock"></i>
                                            Kode berlaku 10 menit
                                        </div>
                                        <a href="{{ route('login') }}" style="color:#2f6fed; text-decoration:none; font-size:.92rem; font-weight:700;">
                                            Kembali ke login
                                        </a>
                                    </div>

                                    <button
                                        type="submit"
                                        style="width:100%; background:linear-gradient(135deg,#4f8cff 0%, #2f6fed 100%); color:#fff; border:none; border-radius:14px; padding:15px; font-weight:800; font-size:1rem; box-shadow:0 14px 28px rgba(47,111,237,.22); transition:transform .15s, box-shadow .2s;"
                                        onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 18px 34px rgba(47,111,237,.28)'"
                                        onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 14px 28px rgba(47,111,237,.22)'">
                                        Verifikasi dan Masuk
                                    </button>
                                </form>

                                <div style="display:flex; align-items:center; gap:12px; margin:28px 0 22px;">
                                    <div style="flex:1; height:1px; background:#e2e8f0;"></div>
                                    <span style="color:#94a3b8; font-size:.84rem;">opsi lain</span>
                                    <div style="flex:1; height:1px; background:#e2e8f0;"></div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <form action="{{ route('two-factor.resend') }}" method="POST" class="h-100">
                                            @csrf
                                            <button type="submit" style="width:100%; height:100%; background:#fff; color:#334155; border:1.5px solid #e2e8f0; border-radius:14px; padding:13px 18px; font-weight:800;">
                                                <i class="bi bi-arrow-clockwise me-2" style="color:#2f6fed;"></i>Kirim Ulang
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-sm-6">
                                        <div style="width:100%; height:100%; background:#f8fbff; color:#64748b; border:1.5px solid #e7eefc; border-radius:14px; padding:13px 18px; font-weight:700; display:flex; align-items:center; justify-content:center;">
                                            <i class="bi bi-envelope-check me-2" style="color:#2f6fed;"></i>Cek inbox email
                                        </div>
                                    </div>
                                </div>

                                <div style="text-align:center; margin-top:26px; color:#64748b; font-size:.94rem; line-height:1.8;">
                                    Jika email belum masuk, cek folder spam atau promosi,
                                    lalu gunakan tombol kirim ulang untuk mendapatkan kode baru.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
