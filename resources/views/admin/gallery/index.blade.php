@extends('layouts.app')
@section('header_title', 'Zarządzanie Galeriami')

@push('styles')
<style>
    .crancy-pcats__list a { letter-spacing: .025em; color: #085c9c!important; font-weight: 400; font-size: 12px; padding: 10px 20px; border-radius: 4px!important; background: #e4f5fc; }
    #galleryList .list-group-item { cursor: pointer; transition: background-color 0.2s ease-in-out; }
    #galleryList .list-group-item.active { background-color: #e4f5fc; border-color: #bde5f8; font-weight: bold; }
    .status-icon { font-size: 10px; }
</style>
@endpush

@section('content')
<div class="content-body">
    <div class="container-fluid">
        @if(session('status'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('status') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>@endif
        @if($errors->any())<div class="alert alert-danger alert-dismissible fade show"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>@endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Lista galerii</h4>
                        <div class="crancy-pcats__bar">
                            <div class="crancy-pcats__list list-group">
                                <a class="list-group-item btn btn-primary" href="{{ route('admin.gallery.create') }}">Dodaj galerię</a>
                                <a class="list-group-item btn btn-primary disabled" href="javascript:void(0)" id="editGalleryBtn">Edytuj galerię</a>
                                <a class="list-group-item btn btn-primary disabled" href="javascript:void(0)" id="toggleGalleryBtn">Zmień status</a>
                                <a class="list-group-item btn btn-danger disabled" href="javascript:void(0)" id="deleteGalleryBtn">Usuń galerię</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="list-group" id="galleryList">
                                @forelse ($galleries as $gallery)
                                    <a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start" data-id="{{ $gallery->id }}" data-is-hidden="{{ $gallery->is_hidden ? '1' : '0' }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-0">
                                                <i class="fa fa-circle status-icon {{ $gallery->is_hidden ? 'text-danger' : 'text-success' }}"></i>
                                                {{ $gallery->title }}
                                            </h5>
                                            <small class="text-muted text-end">
                                                <span>{{ $gallery->created_at->format('Y-m-d') }}</span><br>
                                                <span><b>{{ $gallery->user->name ?? 'Brak autora' }}</b></span>
                                            </small>
                                        </div>
                                        <p class="mb-2 ms-4">{{ Str::limit($gallery->description, 120) }}</p>
                                        <small class="ms-4"><p class="mb-0 mt-0"><b>Zawartość: </b><span>{{ $gallery->images->count() }} zdjęć</span></p></small>
                                    </a>
                                @empty
                                    <p class="text-center p-3">Brak galerii do wyświetlenia. Kliknij "Dodaj galerię", aby stworzyć pierwszą.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="actionForm" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="_method" id="formMethodInput">
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedGalleryId = null;
    let selectedIsHidden = false;

    const editBtn = document.getElementById('editGalleryBtn');
    const toggleBtn = document.getElementById('toggleGalleryBtn');
    const deleteBtn = document.getElementById('deleteGalleryBtn');
    const galleryList = document.getElementById('galleryList');
    const actionForm = document.getElementById('actionForm');
    const formMethodInput = document.getElementById('formMethodInput');

    function updateButtonStates() {
        if (selectedGalleryId) {
            editBtn.href = `{{ url('admin/galleries') }}/${selectedGalleryId}/edit`;
            editBtn.classList.remove('disabled');
            toggleBtn.classList.remove('disabled');
            deleteBtn.classList.remove('disabled');
            toggleBtn.textContent = selectedIsHidden ? 'Opublikuj galerię' : 'Ukryj galerię';
        } else {
            editBtn.href = 'javascript:void(0)';
            editBtn.classList.add('disabled');
            toggleBtn.classList.add('disabled');
            deleteBtn.classList.add('disabled');
            toggleBtn.textContent = 'Zmień status';
        }
    }

    galleryList.addEventListener('click', function(e) {
        const item = e.target.closest('.list-group-item');
        if (!item) return;

        if (item.classList.contains('active')) {
            item.classList.remove('active');
            selectedGalleryId = null;
        } else {
            document.querySelectorAll('#galleryList .list-group-item').forEach(el => el.classList.remove('active'));
            item.classList.add('active');
            selectedGalleryId = item.dataset.id;
            selectedIsHidden = item.dataset.isHidden === '1';
        }
        updateButtonStates();
    });

    toggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (this.classList.contains('disabled')) return;
        actionForm.action = `{{ url('admin/galleries') }}/${selectedGalleryId}/toggle-status`;
        formMethodInput.value = 'PATCH';
        actionForm.submit();
    });

    deleteBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (this.classList.contains('disabled')) return;
        if (confirm('Czy na pewno chcesz usunąć tę galerię i wszystkie jej zdjęcia? Operacja jest nieodwracalna.')) {
            actionForm.action = `{{ url('admin/galleries') }}/${selectedGalleryId}`;
            formMethodInput.value = 'DELETE';
            actionForm.submit();
        }
    });
});
</script>
@endpush
