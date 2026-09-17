@extends('layouts.app')

@section('title', 'Login | Stremvans Funds Management')

@section('styles')
<style>
:root{
    --gold:#D6BB00;
    --gold-light:#EBDA4D;
    --gold-deep:#A38F00;
    --black:#1C1C1C;
    --black-2:#242424;
    --black-3:#141414;
    --cream:#F2EFE6;
    --ink-text:#1C1A12;
    --muted:#B0AEA6;
    --parchment:#EFEFEA;
}

body{
    font-family:'Inter',sans-serif;
    background:var(--black);
}

.login-wrapper{
    position:relative;
    min-height:100vh;
    overflow:hidden;
    background:
        radial-gradient(circle at 78% 18%, rgba(214,187,0,.16), transparent 45%),
        radial-gradient(circle at 15% 85%, rgba(214,187,0,.08), transparent 40%),
        linear-gradient(160deg, var(--black-2) 0%, var(--black) 55%, var(--black-3) 100%);
    padding:56px;
}

.ring{
    position:absolute;
    border:1px solid var(--gold);
    border-radius:50%;
    opacity:.22;
    pointer-events:none;
}
.ring.r1{ width:180px; height:180px; top:150px; left:38px; }
.ring.r2{ width:420px; height:420px; bottom:-160px; right:340px; opacity:.08; }

.streak{
    position:absolute;
    width:1px;
    height:340px;
    background:linear-gradient(var(--gold), transparent);
    top:60px;
    left:300px;
    transform:rotate(30deg);
    opacity:.4;
    pointer-events:none;
}

.brand-logo{
    position:relative;
    z-index:1;
    width:190px;
    display:block;
}

.hero{
    position:relative;
    z-index:1;
    margin-top:90px;
    max-width:480px;
}

.hero h1{
    font-family:'Playfair Display',serif;
    font-weight:800;
    font-size:48px;
    color:var(--parchment);
    margin:0 0 16px;
    line-height:1.15;
}

.hero h1 .accent{
    color:var(--gold-light);
    font-style:italic;
}

.hero .bar{
    width:64px;
    height:4px;
    background:linear-gradient(90deg, var(--gold-deep), var(--gold-light));
    margin-bottom:20px;
}

.hero p{
    color:var(--muted);
    line-height:1.8;
    font-size:15px;
    margin:0 0 40px;
}

.features{
    display:flex;
    gap:32px;
    position:relative;
    z-index:1;
    flex-wrap:wrap;
}

.feature{
    text-align:center;
    color:var(--muted);
    font-size:11px;
    letter-spacing:1.5px;
}

.feature .dot{
    width:34px;
    height:34px;
    border:1px solid var(--gold);
    border-radius:50%;
    margin:0 auto 8px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:var(--gold);
    font-size:15px;
}

.login-card{
    position:absolute;
    top:100px;
    right:80px;
    width:390px;
    background:rgba(255,255,255,.04);
    backdrop-filter:blur(14px);
    -webkit-backdrop-filter:blur(14px);
    border:1px solid rgba(255,255,255,.07);
    border-radius:20px;
    padding:38px 34px 30px;
    box-shadow:0 30px 70px rgba(0,0,0,.5);
    z-index:2;
}

.login-card img{
    width:110px;
    display:block;
    margin:0 auto 20px;
}

.login-card h2{
    font-family:'Playfair Display',serif;
    font-weight:700;
    color:var(--parchment);
    font-size:25px;
    margin:0 0 6px;
    text-align:center;
}

.login-card p.subtitle{
    color:var(--muted);
    font-size:13px;
    margin:0 0 26px;
    text-align:center;
}

.form-label{
    display:block;
    color:var(--muted);
    font-size:11.5px;
    letter-spacing:1.5px;
    font-weight:600;
    margin-bottom:8px;
}

.form-control{
    width:100%;
    padding:13px 14px;
    border:none;
    border-radius:10px;
    background:var(--cream);
    color:var(--ink-text);
    font-size:14px;
}

.form-control::placeholder{
    color:#8A8676;
}

.form-control:focus{
    background:var(--cream);
    color:var(--ink-text);
    box-shadow:0 0 0 .15rem rgba(214,187,0,.3);
    outline:none;
}

.field{
    margin-bottom:18px;
}

.form-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin:2px 0 22px;
    font-size:13px;
    color:var(--muted);
}

.form-row a{
    color:var(--gold-light);
    text-decoration:none;
}

.form-row a:hover{
    color:var(--gold);
}

.btn-gold{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:linear-gradient(90deg, var(--gold-deep), var(--gold-light));
    color:#241A02;
    font-weight:700;
    font-size:13.5px;
    letter-spacing:1px;
    cursor:pointer;
    transition:.3s;
}

.btn-gold:hover{
    filter:brightness(1.08);
    transform:translateY(-1px);
    color:#241A02;
}

.version{
    text-align:center;
    color:var(--muted);
    font-size:11.5px;
    margin-top:18px;
}

@media(max-width:992px){

.login-wrapper{
    padding:24px;
}

.hero{
    margin-top:200px;
}

.login-card{
    position:relative;
    top:auto;
    right:auto;
    width:100%;
    max-width:420px;
    margin:40px auto 0;
}

}
</style>
@endsection

@section('content')

<div class="login-wrapper">

    <div class="ring r1"></div>
    <div class="ring r2"></div>
    <div class="streak"></div>

    <img class="brand-logo" src="{{ asset('images/logo1.png') }}" alt="Stremvans Logo">

    <div class="hero">
        <h1>Building Wealth.<br><span class="accent">Creating Impact.</span></h1>
        <div class="bar"></div>
        <p>Delivering trusted investment solutions and sustainable wealth creation through innovative financial services.</p>
    </div>

    <div class="features">
        <div class="feature"><div class="dot"><i class="bi bi-shield-check"></i></div>TRUST</div>
        <div class="feature"><div class="dot"><i class="bi bi-graph-up-arrow"></i></div>PERFORMANCE</div>
        <div class="feature"><div class="dot"><i class="bi bi-people"></i></div>PARTNERSHIP</div>
        <div class="feature"><div class="dot"><i class="bi bi-bullseye"></i></div>IMPACT</div>
    </div>

    <div class="login-card">

        <img src="{{ asset('images/logo2.png') }}" alt="Logo">

        <h2>Welcome Back</h2>
        <p class="subtitle">Sign in to your Stremvans CRM account</p>

        <form method="POST" action="/login">
    @csrf

           <div class="field">
    <label class="form-label">Email Address</label>

    <input
        type="email"
        name="email"
        value="{{ old('email') }}"
        class="form-control"
        placeholder="admin@stremvans.com">

    @error('email')
        <small style="color:#ff8080">{{ $message }}</small>
    @enderror
</div>

           <div class="field">
    <label class="form-label">Password</label>

    <input
        type="password"
        name="password"
        class="form-control"
        placeholder="Enter your password">

    @error('password')
        <small style="color:#ff8080">{{ $message }}</small>
    @enderror
</div>

            <div class="form-row">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="#">Forgot password?</a>
            </div>

            <button type="submit" class="btn-gold">SIGN IN</button>

        </form>

        <div class="version">Version 2.0 &bull; August 2026</div>

    </div>

</div>

@endsection