@extends('layouts.admin.admin')
@section('title', 'Edit Product - SkinQuo')

@push('styles')
<style>
  /* ===== EDIT PRODUCT PAGE ===== */
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500;600&display=swap');

  .edit-product-page {
    padding: 48px 52px 64px;
    max-width: 1440px;
    margin: 0 auto;
    font-family: 'Jost', sans-serif;
  }

  /* ===== PAGE HEADER ===== */
  .edit-product-page .page-header {
    margin-bottom: 48px;
    position: relative;
  }

  .edit-product-page .page-header::after {
    content: '';
    display: block;
    width: 64px;
    height: 2px;
    background: linear-gradient(90deg, var(--brown-dark), transparent);
    margin-top: 20px;
  }

  .edit-product-page .breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
    font-size: 12px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #A67C52;
  }

  .edit-product-page .breadcrumb-nav a {
    color: #A67C52;
    text-decoration: none;
    transition: color 0.15s;
  }

  .edit-product-page .breadcrumb-nav a:hover {
    color: var(--brown-dark);
  }

  .edit-product-page .breadcrumb-nav .separator {
    opacity: 0.5;
    font-size: 10px;
  }

  .edit-product-page .page-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.4rem, 3.2vw, 3.6rem);
    font-weight: 400;
    color: var(--brown-dark);
    line-height: 1.1;
    margin: 0;
  }

  .edit-product-page .page-title em {
    font-style: italic;
    font-weight: 400;
    color: #A67C52;
  }

  .edit-product-page .page-subtitle {
    margin: 12px 0 0;
    font-size: 14px;
    color: #7A5C43;
    line-height: 1.6;
    max-width: 580px;
  }

  .edit-product-page .product-id-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 14px;
    background: #F5EDE3;
    border: 1px solid #E8D5C4;
    border-radius: 999px;
    padding: 5px 14px;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.06em;
    color: #7A5C43;
  }

  .edit-product-page .product-id-badge i {
    font-size: 12px;
    color: #A67C52;
  }

  /* ===== MAIN LAYOUT ===== */
  .edit-product-page .form-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 32px;
    align-items: flex-start;
  }

  /* ===== CARD BASE ===== */
  .edit-product-page .form-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(61, 35, 20, 0.07);
    overflow: hidden;
  }

  .edit-product-page .form-card-header {
    padding: 24px 32px 20px;
    border-bottom: 1px solid #F0E8DC;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .edit-product-page .form-card-header .card-icon {
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

  .edit-product-page .form-card-header .card-title {
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--brown-dark);
    margin: 0;
  }

  .edit-product-page .form-card-body {
    padding: 28px 32px;
  }

  /* ===== FORM ELEMENTS ===== */
  .edit-product-page .field-group {
    margin-bottom: 24px;
  }

  .edit-product-page .field-group:last-child {
    margin-bottom: 0;
  }

  .edit-product-page .field-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }

  .edit-product-page .field-row-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 20px;
  }

  .edit-product-page label {
    display: block;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #7A5C43;
    margin-bottom: 8px;
  }

  .edit-product-page label .required-dot {
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

  .edit-product-page .form-input,
  .edit-product-page .form-select {
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

  .edit-product-page .form-input:focus,
  .edit-product-page .form-select:focus {
    border-color: var(--brown-dark);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(74, 36, 19, 0.08);
  }

  .edit-product-page .form-input::placeholder {
    color: #C4A98E;
    font-style: italic;
  }

  .edit-product-page .form-input.is-invalid,
  .edit-product-page .form-select.is-invalid {
    border-color: #C0392B;
    background: #FFF8F8;
  }

  .edit-product-page .error-msg {
    display: block;
    font-size: 11px;
    color: #C0392B;
    margin-top: 6px;
    letter-spacing: 0.02em;
  }

  /* Select Wrapper */
  .edit-product-page .select-wrapper {
    position: relative;
  }

  .edit-product-page .select-wrapper::after {
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
  .edit-product-page .form-textarea {
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

  .edit-product-page .form-textarea:focus {
    border-color: var(--brown-dark);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(74, 36, 19, 0.08);
  }

  .edit-product-page .form-textarea::placeholder {
    color: #C4A98E;
    font-style: italic;
  }

  /* Price Input */
  .edit-product-page .price-wrapper {
    position: relative;
    display: flex;
    align-items: center;
  }

  .edit-product-page .price-wrapper .currency {
    position: absolute;
    left: 16px;
    font-size: 13px;
    font-weight: 600;
    color: #A67C52;
    letter-spacing: 0.05em;
    pointer-events: none;
    z-index: 1;
  }

  .edit-product-page .price-wrapper .form-input {
    padding-left: 52px;
  }

  /* URL Input */
  .edit-product-page .url-wrapper {
    position: relative;
  }

  .edit-product-page .url-wrapper .url-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #A67C52;
    font-size: 14px;
    pointer-events: none;
    z-index: 1;
  }

  .edit-product-page .url-wrapper .form-input {
    padding-left: 40px;
  }

  /* ===== RIGHT SIDEBAR ===== */
  .edit-product-page .sidebar-stack {
    display: flex;
    flex-direction: column;
    gap: 20px;
    position: sticky;
    top: 24px;
  }

  /* Current Image Card */
  .edit-product-page .image-preview-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(61, 35, 20, 0.07);
    overflow: hidden;
  }

  .edit-product-page .image-preview-card .preview-header {
    padding: 18px 24px 14px;
    border-bottom: 1px solid #F0E8DC;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .edit-product-page .image-preview-card .preview-header .card-icon {
    width: 32px;
    height: 32px;
    background: #F5EDE3;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brown-dark);
    font-size: 14px;
    flex-shrink: 0;
  }

  .edit-product-page .image-preview-card .preview-header .card-title {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--brown-dark);
    margin: 0;
  }

  .edit-product-page .product-thumb-container {
    padding: 20px;
    background: #FAFAF8;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 180px;
  }

  .edit-product-page .product-thumb-container img {
    max-width: 100%;
    max-height: 200px;
    object-fit: contain;
    border-radius: 8px;
  }

  .edit-product-page .no-image-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    color: #C4A98E;
    font-size: 12px;
    text-align: center;
  }

  .edit-product-page .no-image-placeholder i {
    font-size: 36px;
    opacity: 0.5;
  }

  /* Visibility Toggle Card */
  .edit-product-page .visibility-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(61, 35, 20, 0.07);
    padding: 24px 28px;
  }

  .edit-product-page .visibility-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }

  .edit-product-page .visibility-info .vis-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--brown-dark);
    display: block;
    margin-bottom: 4px;
  }

  .edit-product-page .visibility-info .vis-desc {
    font-size: 12px;
    color: #A67C52;
    line-height: 1.4;
    display: block;
  }

  /* Toggle Switch */
  .edit-product-page .toggle-switch {
    position: relative;
    width: 48px;
    height: 26px;
    flex-shrink: 0;
  }

  .edit-product-page .toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
  }

  .edit-product-page .toggle-track {
    position: absolute;
    inset: 0;
    background: #E8D5C4;
    border-radius: 999px;
    cursor: pointer;
    transition: background 0.25s;
  }

  .edit-product-page .toggle-track::after {
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

  .edit-product-page .toggle-switch input:checked + .toggle-track {
    background: var(--brown-dark);
  }

  .edit-product-page .toggle-switch input:checked + .toggle-track::after {
    transform: translateX(22px);
  }

  /* Action Buttons */
  .edit-product-page .action-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(61, 35, 20, 0.07);
    padding: 24px 28px;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .edit-product-page .btn-save-primary {
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

  .edit-product-page .btn-save-primary:hover {
    background: #5C2E10;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(61, 35, 20, 0.25);
  }

  .edit-product-page .btn-save-primary:active {
    transform: translateY(0);
  }

  .edit-product-page .btn-save-primary i {
    font-size: 16px;
  }

  .edit-product-page .btn-cancel-outline {
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

  .edit-product-page .btn-cancel-outline:hover {
    background: #F5EDE3;
    border-color: #D4B896;
    color: var(--brown-dark);
    text-decoration: none;
  }

  /* ===== ALERT / NOTIFICATION ===== */
  .edit-product-page .alert-success {
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

  .edit-product-page .alert-error {
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
    .edit-product-page .form-layout {
      grid-template-columns: 1fr 280px;
    }
  }

  @media (max-width: 992px) {
    .edit-product-page .form-layout {
      grid-template-columns: 1fr;
    }
    .edit-product-page .sidebar-stack {
      position: static;
    }
    .edit-product-page .action-card {
      flex-direction: row;
    }
    .edit-product-page .btn-save-primary,
    .edit-product-page .btn-cancel-outline {
      flex: 1;
    }
  }

  @media (max-width: 768px) {
    .edit-product-page {
      padding: 32px 24px 48px;
    }
    .edit-product-page .field-row,
    .edit-product-page .field-row-3 {
      grid-template-columns: 1fr;
    }
    .edit-product-page .form-card-body {
      padding: 22px 20px;
    }
    .edit-product-page .form-card-header {
      padding: 20px 20px 16px;
    }
    .edit-product-page .action-card {
      flex-direction: column;
    }
  }
</style>
@endpush

@section('content')

<div class="edit-product-page">

  {{-- ===== PAGE HEADER ===== --}}
  <div class="page-header">
    <nav class="breadcrumb-nav">
      <a href="{{ route('admin.products.index') }}">Inventory</a>
      <span class="separator">›</span>
      <span>Edit Product</span>
    </nav>
    <h1 class="page-title">Refine your <em>Product</em></h1>
    <p class="page-subtitle">Update the details for <strong>{{ $product->nama_produk }}</strong>.</p>
    <div class="product-id-badge">
      <i class="bi bi-hash"></i>
      Product ID: {{ $product->product_id }}
    </div>
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
  <form
    method="POST"
    action="{{ route('admin.products.update', $product->product_id) }}"
    enctype="multipart/form-data"
    id="product-edit-form"
  >
    @csrf
    @method('PUT')

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
                  value="{{ old('nama_produk', $product->nama_produk) }}"
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
                  value="{{ old('nama_brand', $product->nama_brand) }}"
                  required
                >
                @error('nama_brand')<span class="error-msg">{{ $message }}</span>@enderror
              </div>
            </div>

            <div class="field-group">
              <label>Category <span class="required-dot"></span></label>
              <div class="select-wrapper">
                <select name="kategori_produk" class="form-select {{ $errors->has('kategori_produk') ? 'is-invalid' : '' }}" required>
                  <option value="" disabled>Select a category…</option>
                  @foreach(['Face Wash','Toner','Serum','Essence','Moisturizer','Sunscreen','Lip Balm','Sheet Mask','Cleansing Oil','Acne Pimple Patch','Exfoliator','Eye Cream','Other'] as $cat)
                    <option value="{{ $cat }}" {{ old('kategori_produk', $product->kategori_produk) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
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
              >{{ old('deskripsi', $product->deskripsi) }}</textarea>
              @error('deskripsi')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field-group">
              <label>How to Use</label>
              <textarea
                name="cara_pakai"
                class="form-textarea {{ $errors->has('cara_pakai') ? 'is-invalid' : '' }}"
                rows="4"
                placeholder="Step-by-step instructions for best results…"
              >{{ old('cara_pakai', $product->cara_pakai) }}</textarea>
              @error('cara_pakai')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="field-group">
              <label>Key Ingredients</label>
              <textarea
                name="kandungan"
                class="form-textarea {{ $errors->has('kandungan') ? 'is-invalid' : '' }}"
                rows="3"
                placeholder="e.g. Water, Niacinamide 10%, Zinc 1%…"
              >{{ old('kandungan', $product->kandungan) }}</textarea>
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
                    value="{{ old('harga_min', $product->harga_min) }}"
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
                    value="{{ old('harga_max', $product->harga_max) }}"
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
                  value="{{ old('link_produk', $product->link_produk) }}"
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
                  value="{{ old('image', $product->image) }}"
                >
              </div>
              @error('image')<span class="error-msg">{{ $message }}</span>@enderror
            </div>

          </div>
        </div>

      </div>{{-- end form-main --}}

      {{-- ===== RIGHT SIDEBAR ===== --}}
      <div class="sidebar-stack">

        {{-- Current Image Preview --}}
        <div class="image-preview-card">
          <div class="preview-header">
            <div class="card-icon"><i class="bi bi-image"></i></div>
            <h4 class="card-title">Current Image</h4>
          </div>
          <div class="product-thumb-container">
            @if($product->image)
              <img
                id="currentImagePreview"
                src="{{ $product->image }}"
                alt="{{ $product->nama_produk }}"
                onerror="this.style.display='none'; document.getElementById('noImgPlaceholder').style.display='flex';"
              >
              <div id="noImgPlaceholder" class="no-image-placeholder" style="display:none;">
                <i class="bi bi-image-alt"></i>
                <span>Image unavailable</span>
              </div>
            @else
              <div class="no-image-placeholder">
                <i class="bi bi-image-alt"></i>
                <span>No image set</span>
              </div>
            @endif
          </div>
        </div>

        {{-- Visibility --}}
        <div class="visibility-card">
          <div class="visibility-row">
            <div class="visibility-info">
              <span class="vis-title">Public Visibility</span>
              <span class="vis-desc">Visible on the main collection catalog</span>
            </div>
            <label class="toggle-switch">
              <input type="hidden" name="is_visible" value="0">
              <input type="checkbox" name="is_visible" value="1" checked>
              <span class="toggle-track"></span>
            </label>
          </div>
        </div>

        {{-- Action Buttons --}}
        <div class="action-card">
          <button type="submit" class="btn-save-primary">
            <i class="bi bi-check2-circle"></i>
            Save Changes
          </button>
          <a href="{{ route('admin.products.index') }}" class="btn-cancel-outline">
            <i class="bi bi-arrow-left"></i>
            Back
          </a>
        </div>

      </div>

    </div>{{-- end form-layout --}}
  </form>

</div>

@push('scripts')
<script>
  // Live image URL preview — updates the sidebar thumbnail as you type
  const imageUrlInput = document.getElementById('imageUrlInput');
  const currentImgPreview = document.getElementById('currentImagePreview');

  if (imageUrlInput && currentImgPreview) {
    imageUrlInput.addEventListener('input', function() {
      const url = this.value.trim();
      if (!url) return;
      const testImg = new Image();
      testImg.onload = function() {
        currentImgPreview.src = url;
        currentImgPreview.style.display = '';
        const placeholder = document.getElementById('noImgPlaceholder');
        if (placeholder) placeholder.style.display = 'none';
      };
      testImg.onerror = function() {
        // Keep existing image on bad URL
      };
      testImg.src = url;
    });
  }
</script>
@endpush

@endsection
