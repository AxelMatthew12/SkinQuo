@extends('layouts.admin.admin')

@section('title', 'Monitoring Feedback — SkinQuo Admin')

@section('content')
<div class="feedback-monitor-page">
    {{-- TODO [BACKEND]: Replace sample data with @foreach($feedbacks as $feedback) from controller --}}

    <div class="feedback-header-grid">
        <div>
            <h1>Monitoring Feedback</h1>
            <p class="page-description">Pantau semua pesan dari pengguna</p>
        </div>

        <div class="total-feedback-card">
            <div class="total-feedback-icon">
                <i class="bi bi-chat-square-text"></i>
            </div>
            <div class="total-feedback-stats">
                <strong>{{ $stats['total'] ?? ($feedback->total() ?? 0) }}</strong>
                <span>Total Feedback</span>
            </div>
        </div>
    </div>

    <section class="feedback-panel card-admin">
        <form method="GET" action="{{ route('admin.feedback.monitor') }}" class="feedback-toolbar">
            <label class="search-wrapper">
                <i class="bi bi-search"></i>
                <input name="q" value="{{ request('q') }}" type="search" placeholder="Cari pesan atau nama..." aria-label="Cari pesan atau nama" />
            </label>

            <div class="filter-actions">
                <select name="type" class="filter-select">
                    <option value="">Filter Tipe</option>
                    <option value="">Semua</option>
                    <option value="keluhan">Keluhan</option>
                    <option value="saran">Saran</option>
                    <option value="pujian">Pujian</option>
                </select>
            </div>
        </form>

        <div class="feedback-table-card">
            <table class="feedback-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedback as $item)
                        @php
                            $id = data_get($item, 'id');
                            $name = data_get($item, 'name');
                            $email = data_get($item, 'email');
                            $message = data_get($item, 'message');
                            $date = data_get($item, 'created_at') ? \Carbon\Carbon::parse(data_get($item, 'created_at'))->translatedFormat('d M Y') : '';
                        @endphp
                        <tr>
                            <td data-label="Nama">{{ $name }}</td>
                            <td data-label="Email">{{ $email }}</td>
                            <td data-label="Pesan">{{ Str::limit($message, 80) }}</td>
                            <td data-label="Tanggal">{{ $date }}</td>
                            <td data-label="Aksi"><button class="detail-button" data-id="{{ $id }}" data-name="{{ $name }}" data-email="{{ $email }}" data-date="{{ $date }}" data-message="{{ $message }}">Lihat Detail</button></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Tidak ada feedback untuk ditampilkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="table-footer">
                <div style="display:flex; gap:10px; align-items:center;">
                    <a href="{{ route('admin.feedback.export.csv') }}" class="btn-secondary-admin">⬇ CSV</a>
                    <a href="{{ route('admin.feedback.export.pdf') }}" class="btn-secondary-admin">📄 PDF</a>
                </div>
                <nav class="pagination">
                    @if(method_exists($feedback, 'currentPage'))
                        @php
                            $current = $feedback->currentPage();
                            $last = $feedback->lastPage();
                        @endphp
                        <button class="page-btn" {{ $current === 1 ? 'disabled' : '' }}>‹</button>
                        @for($page = 1; $page <= min(3, $last); $page++)
                            <button class="page-btn {{ $page === $current ? 'active' : '' }}">{{ $page }}</button>
                        @endfor
                        @if($last > 4)
                            <span>...</span>
                            <button class="page-btn">{{ $last }}</button>
                        @elseif($last > 3)
                            @for($page = 4; $page <= $last; $page++)
                                <button class="page-btn {{ $page === $current ? 'active' : '' }}">{{ $page }}</button>
                            @endfor
                        @endif
                        <button class="page-btn" {{ $current === $last ? 'disabled' : '' }}>›</button>
                    @else
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <span>...</span>
                        <button class="page-btn">128</button>
                    @endif
                </nav>
            </div>
        </div>
    </section>
</div>

<div id="feedback-detail-modal" class="feedback-modal hidden" role="dialog" aria-modal="true" aria-labelledby="feedbackModalTitle">
    <div class="feedback-modal-backdrop"></div>
    <div class="feedback-modal-card">
        <button type="button" class="close-modal" aria-label="Tutup detail feedback">×</button>
        <div class="feedback-modal-content">
            <div class="modal-profile-panel">
                <div class="modal-avatar"></div>
                <div class="modal-user-info">
                    <strong class="modal-name">Elena Miller</strong>
                    <span class="modal-email">elena.m@example.com</span>
                    <p class="modal-date-label">Date Received</p>
                    <p class="modal-date">October 24, 2023</p>
                </div>
            </div>
            <div class="modal-message-panel">
                <div class="modal-header-row">
                    <h2 id="feedbackModalTitle">Feedback Details</h2>
                </div>
                <span class="modal-message-label">User Message</span>
                <div class="modal-quote">
                    <p id="feedbackDetailMessage">Mungkin bisa ditambahkan varian baru untuk serum malam hari yang lebih fokus pada hidrasi mendalam dan perbaikan skin barrier. Saya sangat menyukai tekstur produk yang sekarang, tapi merasa butuh sesuatu yang sedikit lebih kaya untuk cuaca dingin.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const modal = document.getElementById('feedback-detail-modal');
    const detailButtons = document.querySelectorAll('.detail-button');
    const closeModalButton = document.querySelector('.close-modal');
    const modalName = document.querySelector('.modal-name');
    const modalEmail = document.querySelector('.modal-email');
    const modalDate = document.querySelector('.modal-date');
    const modalMessage = document.getElementById('feedbackDetailMessage');
    const modalAvatar = document.querySelector('.modal-avatar');
    // Removed action buttons (approve/reject/helpful) per UI update

    function openModal({ name, email, date, message }) {
        modalName.textContent = name;
        modalEmail.textContent = email;
        modalDate.textContent = date;
        modalMessage.textContent = message;
        modalAvatar.textContent = '';
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    detailButtons.forEach(button => {
        button.addEventListener('click', () => {
            openModal({
                name: button.dataset.name,
                email: button.dataset.email,
                date: button.dataset.date,
                message: button.dataset.message,
            });
        });
    });

    // keep dataset id for potential use
    detailButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.dataset.feedbackId = button.dataset.id;
        });
    });

    closeModalButton.addEventListener('click', closeModal);
    document.querySelector('.feedback-modal-backdrop').addEventListener('click', closeModal);
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
</script>
@endpush
