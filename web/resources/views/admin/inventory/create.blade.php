@extends('layouts.admin.admin')
@section('title', 'Add New Product - SkinQuo')

@push('styles')
<style>
  /* ===== CREATE PRODUCT PAGE ===== */
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500;600&display=swap');

  .create-product-page {
    padding: 48px 52px 64px;
    max-width: 1440px;
    margin: 0 auto;
    font-family: 'Jost', sans-serif;
  }

  /* ===== PAGE HEADER ===== */
  .create-product-page .page-header {
    margin-bottom: 48px;
    position: relative;
  }

  .create-product-page .page-header::after {
    content: '';
    display: block;
    width: 64px;
    height: 2px;
    background: linear-gradient(90deg, var(--brown-dark), transparent);
    margin-top: 20px;
  }

  .create-product-page .breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
    font-size: 12px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #A67C52;
  }

  .create-product-page .breadcrumb-nav a {
    color: #A67C52;
    text-decoration: none;
    transition: color 0.15s;
  }

  .create-product-page .breadcrumb-nav a:hover {
    color: var(--brown-dark);
  }

  .create-product-page .breadcrumb-nav .separator {
    opacity: 0.5;
    font-size: 10px;
  }

  .create-product-page .page-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.4rem, 3.2vw, 3.6rem);
    font-weight: 400;
    color: var(--brown-dark);
    line-height: 1.1;
    margin: 0;
  }

  .create-product-page .page-title em {
    font-style: italic;
    font-weight: 400;
    color: #A67C52;
  }

  .create-product-page .page-subtitle {
    margin: 12px 0 0;
    font-size: 14px;
    color: #7A5C43;
    line-height: 1.6;
    max-width: 580px;
  }

  /* ===== MAIN LAYOUT ===== */
  .create-product-page .form-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 320px;
    gap: 32px;
    align-items: start;
  }

  .create-product-page .form-main {
    min-width: 0;
  }

  /* ===== CARD BASE ===== */
  .create-product-page .form-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(61, 35, 20, 0.07);
    overflow: hidden;
  }

  .create-product-page .form-card-header {
    padding: 24px 32px 20px;
    border-bottom: 1px solid #F0E8DC;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .create-product-page .form-card-header .card-icon {
    width: 36px;
    height: 36px;
    background: #F5EDE3;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brown-dark);
    font-size: 16px;
    flex-shrink: 0;
  }

  .create-product-page .form-card-header .card-title {
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--brown-dark);
    margin: 0;
  }

  .create-product-page .form-card-body {
    padding: 28px 32px;
  }

  /* ===== FORM ELEMENTS ===== */
  .create-product-page .field-group {
    margin-bottom: 24px;
  }

  .create-product-page .field-group:last-child {
    margin-bottom: 0;
  }

  .create-product-page .field-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }

  .create-product-page .field-row-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 20px;
  }

  .create-product-page label {
    display: block;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #7A5C43;
    margin-bottom: 8px;
  }

  .create-product-page label .required-dot {
    display: inline-block;
    width: 5px;
    height: 5px;
    background: #C0392B;
    border-radius: 50%;
    margin-left: 4px;
    vertical-align: middle;
    position: relative;
    top: -1px;
  }

  .create-product-page .form-input,
  .create-product-page .form-select {
    width: 100%;
    padding: 13px 16px;
    background: #FAFAF8;
    border: 1.5px solid #E8D5C4;
    border-radius: 12px;
    font-family: 'Jost', sans-serif;
    font-size: 14px;
    color: #3D2314;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    outline: none;
    box-sizing: border-box;
    appearance: none;
    -webkit-appearance: none;
  }

  .create-product-page .form-input:focus,
  .create-product-page .form-select:focus {
    border-color: var(--brown-dark);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(74, 36, 19, 0.08);
  }

  .create-product-page .form-input::placeholder {
    color: #C4A98E;
    font-style: italic;
  }

  .create-product-page .form-input.is-invalid,
  .create-product-page .form-select.is-invalid {
    border-color: #C0392B;
    background: #FFF8F8;
  }

  .create-product-page .error-msg {
    display: block;
    font-size: 11px;
    color: #C0392B;
    margin-top: 6px;
    letter-spacing: 0.02em;
  }

  /* Select Wrapper */
  .create-product-page .select-wrapper {
    position: relative;
  }

  .create-product-page .select-wrapper::after {
    content: '';
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid #A67C52;
    pointer-events: none;
  }

  /* Textarea */
  .create-product-page .form-textarea {
    width: 100%;
    padding: 14px 16px;
    background: #FAFAF8;
    border: 1.5px solid #E8D5C4;
    border-radius: 12px;
    font-family: 'Jost', sans-serif;
    font-size: 14px;
    color: #3D2314;
    line-height: 1.65;
    resize: vertical;
    min-height: 120px;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    outline: none;
    box-sizing: border-box;
  }

  .create-product-page .form-textarea:focus {
    border-color: var(--brown-dark);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(74, 36, 19, 0.08);
  }

  .create-product-page .form-textarea::placeholder {
    color: #C4A98E;
    font-style: italic;
  }

  /* Price Input */
  .create-product-page .price-wrapper {
    position: relative;
    display: flex;
    align-items: center;
  }

  .create-product-page .price-wrapper .currency {
    position: absolute;
    left: 16px;
    font-size: 13px;
    font-weight: 600;
    color: #A67C52;
    letter-spacing: 0.05em;
    pointer-events: none;
    z-index: 1;
  }

  .create-product-page .price-wrapper .form-input {
    padding-left: 52px;
  }

  /* URL Input */
  .create-product-page .url-wrapper {
    position: relative;
  }

  .create-product-page .url-wrapper .url-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #A67C52;
    font-size: 14px;
    pointer-events: none;
    z-index: 1;
  }

  .create-product-page .url-wrapper .form-input {
    padding-left: 40px;
  }

  /* Image Upload Area */
  .create-product-page .image-upload-area {
    border: 2px dashed #E8D5C4;
    border-radius: 16px;
    padding: 32px 24px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    background: #FAFAF8;
    position: relative;
  }

  .create-product-page .image-upload-area:hover {
    border-color: var(--brown-dark);
    background: #FFF8F3;
  }

  .create-product-page .image-upload-area input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
  }

  .create-product-page .upload-icon {
    font-size: 32px;
    color: #D4B896;
    margin-bottom: 12px;
    display: block;
  }

  .create-product-page .upload-label {
    font-size: 13px;
    color: #A67C52;
    line-height: 1.5;
    display: block;
  }

  .create-product-page .upload-label strong {
    color: var(--brown-dark);
    font-weight: 600;
  }

  .create-product-page .upload-hint {
    font-size: 11px;
    color: #C4A98E;
    margin-top: 8px;
    display: block;
    letter-spacing: 0.04em;
  }

  /* OR Divider */
  .create-product-page .or-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 16px 0;
  }

  .create-product-page .or-divider::before,
  .create-product-page .or-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #E8D5C4;
  }

  .create-product-page .or-divider span {
    font-size: 10px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #A67C52;
    font-weight: 500;
  }

  /* Image Preview */
  .create-product-page .image-preview-box {
    display: none;
    width: 100%;
    aspect-ratio: 1;
    border-radius: 12px;
    overflow: hidden;
    background: #F5EDE3;
    margin-bottom: 12px;
  }

  .create-product-page .image-preview-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
  }

  .create-product-page .image-preview-box.active {
    display: block;
  }

  /* ===== RIGHT SIDEBAR ===== */
  .create-product-page .sidebar-stack {
    display: flex;
    flex-direction: column;
    gap: 20px;
    position: sticky;
    top: 32px;
    align-self: start;
    height: fit-content;
    max-height: none;
    overflow: visible;
  }

  /* Visibility Toggle Card */
  .create-product-page .visibility-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(61, 35, 20, 0.07);
    padding: 24px 28px;
  }

  .create-product-page .visibility-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }

  .create-product-page .visibility-info .vis-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--brown-dark);
    display: block;
    margin-bottom: 4px;
  }

  .create-product-page .visibility-info .vis-desc {
    font-size: 12px;
    color: #A67C52;
    line-height: 1.4;
    display: block;
  }

  /* Toggle Switch */
  .create-product-page .toggle-switch {
    position: relative;
    width: 48px;
    height: 26px;
    flex-shrink: 0;
  }

  .create-product-page .toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
  }

  .create-product-page .toggle-track {
    position: absolute;
    inset: 0;
    background: #E8D5C4;
    border-radius: 999px;
    cursor: pointer;
    transition: background 0.25s;
  }

  .create-product-page .toggle-track::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    background: #ffffff;
    border-radius: 50%;
    top: 3px;
    left: 3px;
    transition: transform 0.25s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.2);
  }

  .create-product-page .toggle-switch input:checked + .toggle-track {
    background: var(--brown-dark);
  }

  .create-product-page .toggle-switch input:checked + .toggle-track::after {
    transform: translateX(22px);
  }

  /* Action Buttons */
  .create-product-page .action-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(61, 35, 20, 0.07);
    padding: 24px 28px;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .create-product-page .btn-save-primary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 15px 24px;
    background: var(--brown-dark);
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-family: 'Jost', sans-serif;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
  }

  .create-product-page .btn-save-primary:hover {
    background: #5C2E10;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(61, 35, 20, 0.25);
  }

  .create-product-page .btn-save-primary:active {
    transform: translateY(0);
  }

  .create-product-page .btn-save-primary i {
    font-size: 16px;
  }

  .create-product-page .btn-cancel-outline {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 13px 24px;
    background: transparent;
    color: #7A5C43;
    border: 1.5px solid #E8D5C4;
    border-radius: 12px;
    font-family: 'Jost', sans-serif;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
  }

  .create-product-page .btn-cancel-outline:hover {
    background: #F5EDE3;
    border-color: #D4B896;
    color: var(--brown-dark);
    text-decoration: none;
  }

  /* Tips Card */
  .create-product-page .tips-card {
    background: linear-gradient(135deg, #FDF3EA 0%, #F5E6D5 100%);
    border-radius: 20px;
    padding: 24px 28px;
    border: 1px solid #EDD5B8;
  }

  .create-product-page .tips-title {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--brown-dark);
    margin: 0 0 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .create-product-page .tips-title i {
    font-size: 14px;
    color: #C4952A;
  }

  .create-product-page .tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .create-product-page .tips-list li {
    font-size: 12px;
    color: #7A5C43;
    line-height: 1.5;
    padding-left: 16px;
    position: relative;
  }

  .create-product-page .tips-list li::before {
    content: '·';
    position: absolute;
    left: 4px;
    color: #C4952A;
    font-size: 18px;
    line-height: 1;
    top: -1px;
  }

  /* ===== ALERT / NOTIFICATION ===== */
  .create-product-page .alert-success {
    background: #F0FFF4;
    border: 1px solid #6BCB8B;
    border-radius: 12px;
    padding: 14px 20px;
    font-size: 13px;
    color: #276749;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 28px;
  }

  .create-product-page .alert-error {
    background: #FFF5F5;
    border: 1px solid #FC8181;
    border-radius: 12px;
    padding: 14px 20px;
    font-size: 13px;
    color: #9B2335;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 28px;
  }

  /* ===== RESPONSIVE ===== */
  @media (max-width: 1200px) {
    .create-product-page .form-layout {
      grid-template-columns: minmax(0, 1fr) 280px;
    }
  }

  @media (max-width: 992px) {
    .create-product-page .form-layout {
      grid-template-columns: 1fr;
    }
    .create-product-page .sidebar-stack {
      position: static;
    }
    .create-product-page .action-card {
      flex-direction: row;
    }
    .create-product-page .btn-save-primary,
    .create-product-page .btn-cancel-outline {
      flex: 1;
    }
  }

  @media (max-width: 768px) {
    .create-product-page {
      padding: 32px 24px 48px;
    }
    .create-product-page .field-row,
    .create-product-page .field-row-3 {
      grid-template-columns: 1fr;
    }
    .create-product-page .form-card-body {
      padding: 22px 20px;
    }
    .create-product-page .form-card-header {
      padding: 20px 20px 16px;
    }
    .create-product-page .action-card {
      flex-direction: column;
    }
  }
</style>
@endpush

@section('content')

<div class="create-product-page">

  {{-- ===== PAGE HEADER ===== --}}
  <div class="page-header">
    <nav class="breadcrumb-nav">
      <a href="{{ route('admin.products.index') }}">Inventory</a>
      <span class="separator">›</span>
      <span>New Product</span>
    </nav>
    <h1 class="page-title">Make your new <em>Product</em></h1>
    <p class="page-subtitle">Complete the details below to add a new product to the SkinQuo catalog.</p>
  </div>

  {{-- ===== ALERTS ===== --}}
  @if(session('success'))
    <div class="alert-success">
      <i class="bi bi-check-circle-fill"></i>
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div class="alert-error">
      <i class="bi bi-exclamation-circle-fill"></i>
      Please review the errors below and try again.
    </div>
  @endif

  {{-- ===== FORM ===== --}}
  <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="product-form">
    @csrf

    <div class="form-layout">

      {{-- ===== LEFT COLUMN: FORM FIELDS ===== --}}
      <div class="form-main">

        {{-- CARD 1: Core Info --}}
        <div class="form-card" style="margin-bottom: 24px;">
          <div class="form-card-header">
            <div class="card-icon"><i class="bi bi-tag"></i></div>
            <h3 class="card-title">Product Identity</h3>
          </div>
          <div class="form-card-body">

            <div class="field-row field-group">
              <div>
                <label>Product Name <span class="required-dot"></span></label>
                <input
                  type="text"
                  name="nama_produk"
                  class="form-input {{ $errors->has('nama_produk') ? 'is-invalid' : '' }}"
                  placeholder="e.g. Saffron Infused Serum"
                  value="{{ old('nama_produk') }}"
                  required
                >
                @error('nama_produk')<span class="error-msg">{{ $message }}</span>@enderror
              </div>
              <div>
                <label>Brand Name <span class="required-dot"></span></label>
                <input
                  type="text"
                  name="nama_brand"
                  class="form-input {{ $errors->has('nama_brand') ? 'is-invalid' : '' }}"
                  placeholder="e.g. COSRX, Skintific"
                  value="{{ old('nama_brand') }}"
                  required
                >
                @error('nama_brand')<span class="error-msg">{{ $message }}</span>@enderror
              </div>
            </div>

            <div class="field-group">
              <label>Category <span class="required-dot"></span></label>
              <div class="select-wrapper">
                <select name="kategori_produk" class="form-select {{ $errors->has('kategori_produk') ? 'is-invalid' : '' }}" required>
                  <option value="" disabled {{ old('kategori_produk') ? '' : 'selected' }}>Select a category…</option>
                  @foreach(['Face Wash','Toner','Serum','Essence','Moisturizer','Sunscreen','Lip Balm','Sheet Mask','Cleansing Oil','Acne Pimple Patch','Exfoliator','Eye Cream','Other'] as $cat)
                    <option value="{{ $cat }}" {{ old('kategori_produk') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                  @endforeach
                </select>
              </div>
              @error('kategori_produk')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

          </div>
        </div>

        {{-- CARD 2: Description & Usage --}}
        <div class="form-card" style="margin-bottom: 24px;">
          <div class="form-card-header">
            <div class="card-icon"><i class="bi bi-text-paragraph"></i></div>
            <h3 class="card-title">Description & Usage</h3>
          </div>
          <div class="form-card-body">

            <div class="field-group">
              <label>Product Description</label>
              <textarea
                name="deskripsi"
                class="form-textarea {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                rows="5"
                placeholder="Describe the product's benefits, formulation highlights, and what makes it special…"
              >{{ old('deskripsi') }}</textarea>
              @error('deskripsi')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field-group">
              <label>How to Use</label>
              <textarea
                name="cara_pakai"
                class="form-textarea {{ $errors->has('cara_pakai') ? 'is-invalid' : '' }}"
                rows="4"
                placeholder="Step-by-step instructions for best results…"
              >{{ old('cara_pakai') }}</textarea>
              @error('cara_pakai')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field-group">
              <label>Key Ingredients</label>
              <textarea
                name="kandungan"
                class="form-textarea {{ $errors->has('kandungan') ? 'is-invalid' : '' }}"
                rows="3"
                placeholder="e.g. Water, Niacinamide 10%, Zinc 1%…"
              >{{ old('kandungan') }}</textarea>
              @error('kandungan')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

          </div>
        </div>

        {{-- CARD 3: Pricing & Link --}}
        <div class="form-card" style="margin-bottom: 24px;">
          <div class="form-card-header">
            <div class="card-icon"><i class="bi bi-currency-exchange"></i></div>
            <h3 class="card-title">Pricing & Commerce</h3>
          </div>
          <div class="form-card-body">

            <div class="field-row field-group">
              <div>
                <label>Minimum Price (IDR)</label>
                <div class="price-wrapper">
                  <span class="currency">Rp</span>
                  <input
                    type="number"
                    name="harga_min"
                    class="form-input {{ $errors->has('harga_min') ? 'is-invalid' : '' }}"
                    placeholder="0"
                    value="{{ old('harga_min', 0) }}"
                    min="0"
                    step="100"
                  >
                </div>
                @error('harga_min')<span class="error-msg">{{ $message }}</span>@enderror
              </div>
              <div>
                <label>Maximum Price (IDR)</label>
                <div class="price-wrapper">
                  <span class="currency">Rp</span>
                  <input
                    type="number"
                    name="harga_max"
                    class="form-input {{ $errors->has('harga_max') ? 'is-invalid' : '' }}"
                    placeholder="0"
                    value="{{ old('harga_max', 0) }}"
                    min="0"
                    step="100"
                  >
                </div>
                @error('harga_max')<span class="error-msg">{{ $message }}</span>@enderror
              </div>
            </div>

            <div class="field-group">
              <label>External E-Commerce Link
                <span style="font-size:10px; text-transform:none; letter-spacing:0; color:#C4A98E; font-weight:400; margin-left:4px;">(Shopee, Tokopedia, etc.)</span>
              </label>
              <div class="url-wrapper">
                <i class="bi bi-link-45deg url-icon"></i>
                <input
                  type="url"
                  name="link_produk"
                  class="form-input {{ $errors->has('link_produk') ? 'is-invalid' : '' }}"
                  placeholder="https://shopee.co.id/product/..."
                  value="{{ old('link_produk') }}"
                >
              </div>
              @error('link_produk')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

          </div>
        </div>

        {{-- CARD 4: Product Image --}}
        <div class="form-card">
          <div class="form-card-header">
            <div class="card-icon"><i class="bi bi-image"></i></div>
            <h3 class="card-title">Product Image</h3>
          </div>
          <div class="form-card-body">

            {{-- Image preview --}}
            <div class="image-preview-box" id="imagePreviewBox">
              <img id="imagePreview" src="" alt="Preview">
            </div>

            {{-- Image URL input --}}
            <div class="field-group">
              <label>Image URL</label>
              <div class="url-wrapper">
                <i class="bi bi-link-45deg url-icon"></i>
                <input
                  type="url"
                  name="image"
                  id="imageUrlInput"
                  class="form-input {{ $errors->has('image') ? 'is-invalid' : '' }}"
                  placeholder="https://images.example.com/product.jpg"
                  value="{{ old('image') }}"
                >
              </div>
              @error('image')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

          </div>
        </div>

      </div>{{-- end form-main --}}

      {{-- ===== RIGHT SIDEBAR ===== --}}
      <div class="sidebar-stack">

        {{-- Visibility --}}
        <div class="visibility-card">
          <div class="visibility-row">
            <div class="visibility-info">
              <span class="vis-title">Public Visibility</span>
              <span class="vis-desc">Visible on the main collection catalog</span>
            </div>
            <label class="toggle-switch">
              <input type="hidden" name="is_visible" value="0">
              <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', 1) ? 'checked' : '' }}>
              <span class="toggle-track"></span>
            </label>
          </div>
        </div>

        {{-- Action Buttons --}}
        <div class="action-card">
          <button type="submit" name="action" value="publish" class="btn-save-primary">
            <i class="bi bi-send-check"></i>
            Save Product
          </button>
          <a href="{{ route('admin.products.index') }}" class="btn-cancel-outline">
            <i class="bi bi-arrow-left"></i>
            Cancel
          </a>
        </div>

        {{-- Tips --}}
        <div class="tips-card">
          <p class="tips-title"><i class="bi bi-lightbulb"></i> Curator's Tips</p>
          <ul class="tips-list">
            <li>Use the product's official name for consistency across the catalog.</li>
            <li>Write descriptions that highlight unique formulation benefits.</li>
            <li>Include all key active ingredients separated by commas.</li>
            <li>Set both min and max price to reflect marketplace range.</li>
            <li>Use a direct image URL from the product's official listing.</li>
          </ul>
        </div>

      </div>

    </div>{{-- end form-layout --}}
  </form>

</div>

@push('scripts')
<script>
  // Live image URL preview
  const imageUrlInput = document.getElementById('imageUrlInput');
  const imagePreview  = document.getElementById('imagePreview');
  const imagePreviewBox = document.getElementById('imagePreviewBox');

  function updateImagePreview(url) {
    if (!url) {
      imagePreviewBox.classList.remove('active');
      return;
    }
    const img = new Image();
    img.onload = function() {
      imagePreview.src = url;
      imagePreviewBox.classList.add('active');
    };
    img.onerror = function() {
      imagePreviewBox.classList.remove('active');
    };
    img.src = url;
  }

  if (imageUrlInput) {
    imageUrlInput.addEventListener('input', function() {
      updateImagePreview(this.value.trim());
    });
    // Show preview if value already exists (e.g. validation fail repopulate)
    if (imageUrlInput.value) updateImagePreview(imageUrlInput.value.trim());
  }
</script>
@endpush

@endsection
