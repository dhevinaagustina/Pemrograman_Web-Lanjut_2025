@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Kategori')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5>Manage Kategori</h5>
            </div>
            <div class="card-body">
                {{-- Tombol Add di ujung kiri --}}
                <div class="mb-3 text-left">
                    <a href="{{ url('kategori/create') }}" class="btn btn-success">Add</a>
                </div>

                {{-- Tabel DataTables dengan wrapper responsif --}}
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
