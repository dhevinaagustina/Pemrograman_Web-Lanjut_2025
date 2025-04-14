@extends('layouts.template')

@push('css')
<style>
    .welcome-card {
        background: linear-gradient(135deg, #5dacbd 0%, #2c7873 100%);
        color: #ffffff;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease-in-out;
    }

    .welcome-card:hover {
        transform: translateY(-2px);
    }

    .welcome-card .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        padding: 1.5rem 1.5rem 0.5rem;
    }

    .welcome-card .card-title {
        font-size: 1.75rem;
        font-weight: 600;
        letter-spacing: -0.5px;
    }

    .welcome-card .card-body {
        padding: 1.5rem;
        font-size: 1rem;
        line-height: 1.7;
    }

    .welcome-card .lead {
        font-size: 1.15rem;
        font-weight: 500;
        margin-bottom: 1.2rem;
    }

    .emoji {
        font-size: 1.3rem;
        vertical-align: middle;
        margin-left: 0.4rem;
    }

    .welcome-card strong {
        color: #ffef9f;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="card welcome-card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-leaf mr-2"></i> Selamat Datang, {{ Auth::user()->name }}! <span class="emoji">🌿</span>
        </h3>
    </div>
    <div class="card-body">
        <p class="lead mb-4">
            Halo, semoga harimu penuh kedamaian! <span class="emoji">☀️</span>
        </p>
        <p>
            Ini adalah halaman utama aplikasi <strong>POS - Midterm Exam</strong>. 
            Gunakan menu di sebelah kiri untuk mulai menjelajahi fitur. 
            Tetap semangat! <span class="emoji">🚀</span>
        </p>
    </div>
</div>
@endsection