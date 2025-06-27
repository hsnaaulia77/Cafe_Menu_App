<div class="card mb-4">
    <div class="card-header bg-light border-bottom">
        <strong>Informasi Profil</strong>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone', $user->phone) }}" autocomplete="tel">
                    @error('phone')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="photo" class="form-label">Foto Profil</label>
                    <input id="photo" name="photo" type="file" class="form-control" accept="image/*" onchange="previewPhoto(event)">
                    <div id="photo-preview-wrapper" class="mt-2">
                        @if($user->photo)
                            <img id="photo-preview" src="{{ asset('storage/'.$user->photo) }}" alt="Foto Profil" width="80" class="rounded-circle">
                        @else
                            <img id="photo-preview" src="#" alt="Foto Profil" width="80" class="rounded-circle d-none">
                        @endif
                    </div>
                    @error('photo')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input" id="notif_email" name="notif_email" {{ $user->notif_email ? 'checked' : '' }}>
                <label class="form-check-label" for="notif_email">Terima notifikasi email</label>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="notif_promo" name="notif_promo" {{ $user->notif_promo ? 'checked' : '' }}>
                <label class="form-check-label" for="notif_promo">Terima notifikasi promo</label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            @if (session('status') === 'profile-updated')
                <span class="text-success ms-3">Perubahan berhasil disimpan.</span>
            @endif
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewPhoto(event) {
    const input = event.target;
    const preview = document.getElementById('photo-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
