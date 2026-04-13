@extends('layouts.app')

@section('title', 'Verifikasi 2 Langkah')
@section('hide_newsletter', true)
@section('hide_navbar', true)

@section('content')
<div style="min-height: calc(100vh - 200px); background: #f9fafb; display: flex; align-items: center; padding: 48px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div style="background:#fff; border-radius:24px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.1);">
                    <div class="col-12" style="padding:48px 44px;">
                        <div class="text-center mb-5">
                            <div style="width:60px; height:60px; background:#fff7ed; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                                <i class="bi bi-shield-lock" style="font-size:1.8rem; color:#f97316;"></i>
                            </div>
                            <h3 style="font-family:'Playfair Display',serif; font-weight:700; margin-bottom:8px; color:#1a1a2e;">Verifikasi 2 Langkah</h3>
                            <p style="color:#6b7280; font-size:0.95rem; margin-bottom:0;">
                                Kami mengirimkan kode 6 digit ke <strong>{{ $email }}</strong>
                            </p>
                        </div>

                        <form action="{{ route('two-factor.verify') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="code" style="font-weight:700; font-size:0.85rem; color:#374151; display:block; margin-bottom:8px;">Kode Verifikasi</label>
                                <div style="position:relative;">
                                    <i class="bi bi-key" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#9ca3af;"></i>
                                    <input type="text" id="code" name="code" value="{{ old('code') }}"
                                        placeholder="Masukkan 6 digit kode" autofocus required inputmode="numeric" maxlength="6"
                                        class="@error('code') is-invalid @enderror"
                                        style="width:100%; padding:13px 16px 13px 44px; border:1.5px solid #e5e7eb; border-radius:12px; font-size:1rem; letter-spacing:6px; outline:none; transition:border .2s; background:#f9fafb; text-transform:uppercase;"
                                        onfocus="this.style.borderColor='#f97316';this.style.background='#fff'"
                                        onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                                </div>
                                @error('code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit"
                                style="width:100%; background:#f97316; color:#fff; border:none; border-radius:40px; padding:14px; font-weight:700; font-size:1rem; transition:background .2s; cursor:pointer;"
                                onmouseover="this.style.background='#ea6a0a'"
                                onmouseout="this.style.background='#f97316'">
                                <i class="bi bi-check2-circle me-2"></i>Verifikasi dan Masuk
                            </button>
                        </form>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" style="margin-top:24px;">
                            <form action="{{ route('two-factor.resend') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" style="border:none; background:none; color:#f97316; font-weight:700; padding:0;">
                                    Kirim ulang kode
                                </button>
                            </form>

                            <a href="{{ route('login') }}" style="color:#6b7280; text-decoration:none; font-size:0.9rem;">
                                Kembali ke login
                            </a>
                        </div>

                        <div style="background:#f9fafb; border-radius:12px; padding:16px; margin-top:24px; font-size:0.82rem; color:#6b7280; border:1px solid #e5e7eb;">
                            Kode akan kedaluwarsa dalam 10 menit. Jika email belum masuk, cek folder spam atau klik kirim ulang.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
