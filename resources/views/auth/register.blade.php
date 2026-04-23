@extends('layouts.app')

@section('title', 'Register')
@section('hide_newsletter', true)
@section('hide_navbar', true)

@section('content')
<div style="min-height: calc(100vh - 200px); background: #f9fafb; display: flex; align-items: center; padding: 48px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9">
                <div style="background:#fff; border-radius:24px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.1); display:flex; min-height:540px;">

                    {{-- Left panel --}}
                    <div class="d-none d-md-flex col-md-5" style="background:linear-gradient(135deg,#1a1a2e 0%,#0f3460 100%); padding:48px 40px; flex-direction:column; justify-content:space-between; position:relative; overflow:hidden;">
                        <div style="position:absolute; top:-60px; right:-60px; width:200px; height:200px; border-radius:50%; background:rgba(249,115,22,.12);"></div>
                        <div style="position:absolute; bottom:-40px; left:-40px; width:160px; height:160px; border-radius:50%; background:rgba(249,115,22,.08);"></div>
                        <div style="position:relative; z-index:1;">
                            <a href="{{ route('home') }}" style="font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:#fff; text-decoration:none; display:block; margin-bottom:48px;">
                                <i class="bi bi-book-half me-2" style="color:#f97316;"></i>Book<span style="color:#f97316;">Store</span>
                            </a>
                            <h2 style="font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:700; color:#fff; line-height:1.3; margin-bottom:16px;">Join thousands of book lovers today</h2>
                            <p style="color:#9ca3af; line-height:1.8; font-size:0.9rem;">Create your free account and start exploring our curated ebook collection.</p>
                        </div>
                        <div style="position:relative; z-index:1;">
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:36px; height:36px; background:rgba(249,115,22,.2); border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                        <i class="bi bi-person-check" style="color:#f97316;"></i>
                                    </div>
                                    <span style="color:#d1d5db; font-size:0.85rem;">Free account, no subscription</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:36px; height:36px; background:rgba(249,115,22,.2); border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                        <i class="bi bi-book" style="color:#f97316;"></i>
                                    </div>
                                    <span style="color:#d1d5db; font-size:0.85rem;">Buy only what you need</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:36px; height:36px; background:rgba(249,115,22,.2); border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                        <i class="bi bi-infinity" style="color:#f97316;"></i>
                                    </div>
                                    <span style="color:#d1d5db; font-size:0.85rem;">Lifetime access to purchases</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right panel --}}
                    <div class="col-12 col-md-7" style="padding:48px 44px;">
                        <div class="text-center mb-4">
                            <div style="width:60px; height:60px; background:#fff7ed; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                                <i class="bi bi-person-plus" style="font-size:1.8rem; color:#f97316;"></i>
                            </div>
                            <h3 style="font-family:'Playfair Display',serif; font-weight:700; margin-bottom:4px; color:#1a1a2e;">Create Account</h3>
                            <p style="color:#6b7280; font-size:0.9rem; margin-bottom:0;">Join our ebook community for free</p>
                        </div>

                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" style="font-weight:700; font-size:0.85rem; color:#374151; display:block; margin-bottom:8px;">Full Name</label>
                                <div style="position:relative;">
                                    <i class="bi bi-person" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#9ca3af;"></i>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                        placeholder="John Doe" autofocus required
                                        class="@error('name') is-invalid @enderror"
                                        style="width:100%; padding:13px 16px 13px 44px; border:1.5px solid #e5e7eb; border-radius:12px; font-size:0.9rem; outline:none; transition:border .2s; background:#f9fafb;"
                                        onfocus="this.style.borderColor='#f97316';this.style.background='#fff'"
                                        onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" style="font-weight:700; font-size:0.85rem; color:#374151; display:block; margin-bottom:8px;">Email Address</label>
                                <div style="position:relative;">
                                    <i class="bi bi-envelope" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#9ca3af;"></i>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        placeholder="you@example.com" required
                                        class="@error('email') is-invalid @enderror"
                                        style="width:100%; padding:13px 16px 13px 44px; border:1.5px solid #e5e7eb; border-radius:12px; font-size:0.9rem; outline:none; transition:border .2s; background:#f9fafb;"
                                        onfocus="this.style.borderColor='#f97316';this.style.background='#fff'"
                                        onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" style="font-weight:700; font-size:0.85rem; color:#374151; display:block; margin-bottom:8px;">Password</label>
                                <div style="position:relative;">
                                    <i class="bi bi-lock" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#9ca3af;"></i>
                                    <input type="password" id="password" name="password"
                                        placeholder="Min. 8 characters" required
                                        class="@error('password') is-invalid @enderror"
                                        style="width:100%; padding:13px 16px 13px 44px; border:1.5px solid #e5e7eb; border-radius:12px; font-size:0.9rem; outline:none; transition:border .2s; background:#f9fafb;"
                                        onfocus="this.style.borderColor='#f97316';this.style.background='#fff'"
                                        onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" style="font-weight:700; font-size:0.85rem; color:#374151; display:block; margin-bottom:8px;">Confirm Password</label>
                                <div style="position:relative;">
                                    <i class="bi bi-lock-fill" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#9ca3af;"></i>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        placeholder="Repeat password" required
                                        style="width:100%; padding:13px 16px 13px 44px; border:1.5px solid #e5e7eb; border-radius:12px; font-size:0.9rem; outline:none; transition:border .2s; background:#f9fafb;"
                                        onfocus="this.style.borderColor='#f97316';this.style.background='#fff'"
                                        onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                                </div>
                            </div>

                            <button type="submit"
                                style="width:100%; background:#f97316; color:#fff; border:none; border-radius:40px; padding:14px; font-weight:700; font-size:1rem; transition:background .2s; cursor:pointer;"
                                onmouseover="this.style.background='#ea6a0a'"
                                onmouseout="this.style.background='#f97316'">
                                <i class="bi bi-person-check me-2"></i>Create Account
                            </button>
                        </form>

                        {{-- Divider --}}
                        <div style="display:flex; align-items:center; gap:12px; margin:24px 0 16px;">
                            <div style="flex:1; height:1px; background:#e5e7eb;"></div>
                            <span style="color:#9ca3af; font-size:0.8rem; white-space:nowrap;">or sign up with</span>
                            <div style="flex:1; height:1px; background:#e5e7eb;"></div>
                        </div>

                        {{-- Google Register --}}
                        <a href="{{ route('auth.google') }}"
                            style="display:flex; align-items:center; justify-content:center; gap:12px; width:100%; background:#fff; color:#374151; border:1.5px solid #e5e7eb; border-radius:40px; padding:13px; font-weight:700; font-size:0.95rem; text-decoration:none; transition:all .2s; box-shadow:0 1px 4px rgba(0,0,0,.06);"
                            onmouseover="this.style.borderColor='#4285F4';this.style.boxShadow='0 2px 8px rgba(66,133,244,.15)'"
                            onmouseout="this.style.borderColor='#e5e7eb';this.style.boxShadow='0 1px 4px rgba(0,0,0,.06)'">
                            <svg width="20" height="20" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/><path fill="none" d="M0 0h48v48H0z"/></svg>
                            Sign up with Google
                        </a>

                        <div style="text-align:center; margin-top:24px;">
                            <p style="color:#6b7280; font-size:0.88rem; margin-bottom:0;">
                                Already have an account?
                                <a href="{{ route('login') }}" style="color:#f97316; font-weight:700; text-decoration:none;">Sign in</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
