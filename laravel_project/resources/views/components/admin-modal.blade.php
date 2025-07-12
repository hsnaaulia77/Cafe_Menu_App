<div class="admin-modal-bg" x-show="showTambah" style="display: none;">
    <div class="admin-modal-card">
        <button class="admin-modal-close" @click="showTambah = false">&times;</button>
        <h2>{{ $title ?? '' }}</h2>
        {{ $slot }}
    </div>
</div>
<style>
.admin-modal-bg {
    background: rgba(24,24,28,0.85);
    backdrop-filter: blur(4px);
    position: fixed; z-index: 1000; top:0; left:0; width:100vw; height:100vh;
    display: flex; align-items: center; justify-content: center;
}
.admin-modal-card {
    background: rgba(30,30,35,0.98);
    border-radius: 1.3rem;
    box-shadow: 0 8px 48px #000a;
    padding: 2.2rem 2rem 1.5rem 2rem;
    max-width: 420px; width: 96vw;
    color: #ffd700;
    position: relative;
}
.admin-modal-card h2 {
    font-size: 1.3rem; color: #ffd700; margin-bottom: 1.2rem; font-weight: 700;
}
.admin-modal-card input, .admin-modal-card select, .admin-modal-card textarea {
    width: 100%; margin-bottom: 1.1rem;
    background: #232526; color: #ffd700;
    border: 1.5px solid #ffd70033; border-radius: 0.9rem;
    padding: 13px 18px; font-size: 1.08rem;
    transition: border 0.2s, box-shadow 0.2s;
}
.admin-modal-card input:focus, .admin-modal-card select:focus, .admin-modal-card textarea:focus {
    border: 1.5px solid #ffd700;
    box-shadow: 0 2px 12px #ffd70033;
    outline: none;
}
.admin-modal-card label {
    color: #e0b873; font-size: 1.05rem; margin-bottom: 0.3rem; display: block;
}
.admin-modal-card .btn-simpan {
    background: linear-gradient(90deg, #ffd700 0%, #b87333 100%);
    color: #18181c; font-weight: 700; border-radius: 0.9rem;
    border: none; font-size: 1.13rem; box-shadow: 0 2px 12px #b8733340;
    padding: 13px 0; width: 100%; margin-top: 0.5rem;
    transition: box-shadow 0.22s, transform 0.22s, background 0.22s;
}
.admin-modal-card .btn-simpan:hover {
    background: linear-gradient(90deg, #b87333 0%, #ffd700 100%);
    color: #18181c;
}
.admin-modal-close {
    position: absolute; top: 18px; right: 18px; font-size: 1.3rem;
    color: #ffd700; background: none; border: none; cursor: pointer;
    transition: color 0.2s;
}
.admin-modal-close:hover { color: #b87333; }
</style> 