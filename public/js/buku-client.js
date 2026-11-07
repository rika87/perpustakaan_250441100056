const API = '/api';
const FIELD = ['kategori_id', 'judul', 'penulis', 'tahun_terbit'];
const $ = (id) => document.getElementById(id);
let halaman = 1;
const BISA_KELOLA = window.BISA_KELOLA === true;

const esc = (t) =>
    String(t ?? '').replace(/[&<>"']/g, (c) =>
        ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

class ApiError extends Error {
    constructor(status, message, errors = {}) {
        super(message);
        this.status = status; 
        this.errors = errors; 
    }
}

const pesan = (teks, jenis = 'success') => {
    $('alert-area').innerHTML =
        `<div class="bk-alert bk-${jenis}" role="alert">${esc(teks)}</div>`;
};

async function apiRequest(path, { method = 'GET', body = null } = {}) {
    const headers = { Accept: 'application/json' };
    if (body) headers['Content-Type'] = 'application/json';

    let res;
    try { res = await fetch(API + path, {
            method,
            headers,
            body: body ? JSON.stringify(body) : undefined,
        });
    } catch {
        throw new ApiError(0, 'Tidak dapat terhubung ke server. Pastikan server berjalan.');
    }

    const data = await res.json().catch(() => null);

    if (!res.ok) {
        throw new ApiError(res.status, data?.message ?? `HTTP ${res.status}`, data?.errors ?? {});
    }
    return data;
}

function tanganiError(err) {
    FIELD.forEach((f) => { if ($(`err-${f}`)) $(`err-${f}`).textContent = ''; });

    if (err.status === 422) {
        Object.entries(err.errors).forEach(([f, m]) => {
            if ($(`err-${f}`)) $(`err-${f}`).textContent = m.join(' ');
        });
        pesan('Data belum valid. Periksa isian formulir.', 'warning');
    } else if (err.status === 401) {
        pesan('Sesi login berakhir. Silakan masuk kembali.', 'warning');
    } else if (err.status === 403) {
        pesan('Anda tidak memiliki hak akses untuk tindakan ini.', 'danger');
    } else if (err.status === 404) {
        pesan('Data tidak ditemukan. Mungkin sudah dihapus.', 'warning');
        muatBuku(halaman);
    } else if (err.status >= 500) {
        pesan(`Terjadi kesalahan pada server (${err.status}). Coba lagi nanti.`, 'danger');
    } else {
        pesan(err.message, 'danger');
    }
}

async function muatKategori() {
    try {
        const { data } = await apiRequest('/rekap/buku-per-kategori');
        $('buku-kategori_id').insertAdjacentHTML(
            'beforeend',
            data.map((k) => `<option value="${esc(k.kategori_id)}">${esc(k.kategori)}</option>`).join('')
        );
    } catch (err) {
        tanganiError(err);
    }
}

async function muatBuku(page = 1) {
    try {
        const json = await apiRequest(`/buku?page=${page}`);
        halaman = json.meta.current_page;

        if (json.data.length === 0 && halaman > 1) return muatBuku(halaman - 1);

        $('tbody-buku').innerHTML =
            json.data.map((b, i) => `
                <tr>
                    <td>${(json.meta.from ?? 1) + i}</td>
                    <td>${esc(b.kategori)}</td>
                    <td>${esc(b.judul)}</td>
                    <td>${esc(b.penulis)}</td>
                    <td>${esc(b.tahun)}</td>
                    <td>
                        <a class="bk-btn bk-btn-detail" href="/buku/${esc(b.id)}"><i class="fa-solid fa-eye"></i></a>
                        ${BISA_KELOLA ? `<button class="bk-btn bk-btn-ubah" data-aksi="ubah" data-id="${esc(b.id)}"><i class="fa-solid fa-edit"></i></button>
                        <button class="bk-btn bk-btn-hapus" data-aksi="hapus" data-id="${esc(b.id)}"><i class="fa-solid fa-trash"></i></button>` : ''}
                    </td>
                </tr>`).join('')
            || '<tr><td colspan="6" class="bk-center">Belum ada data.</td></tr>';

        $('info-halaman').textContent =
            `Halaman ${json.meta.current_page} dari ${json.meta.last_page} (total ${json.meta.total} buku)`;
        $('btn-prev').disabled = json.links.prev === null;
        $('btn-next').disabled = json.links.next === null;
    } catch (err) {
        $('tbody-buku').innerHTML =
            `<tr><td colspan="6" class="bk-center bk-error">${esc(err.message)}</td></tr>`;
        $('info-halaman').textContent = '';
    }
}

function kosongkanForm() {
    FIELD.forEach((f) => { $(`err-${f}`).textContent = ''; $(`buku-${f}`).value = ''; });
    $('buku-id').value = '';
    $('judul-form').textContent = 'Tambah Buku';
    $('btn-simpan').textContent = 'Simpan';
}

function isiForm(b) {
    FIELD.forEach((f) => { $(`err-${f}`).textContent = ''; });
    $('buku-id').value = b.id;
    $('buku-kategori_id').value = b.kategori_id ?? '';
    $('buku-judul').value = b.judul ?? '';
    $('buku-penulis').value = b.penulis ?? '';
    $('buku-tahun_terbit').value = b.tahun_terbit ?? '';
    $('judul-form').textContent = 'Ubah Buku';
    $('btn-simpan').textContent = 'Perbarui';
    $('form-buku').scrollIntoView({ behavior: 'smooth' });
}

async function simpan(e) {
    e.preventDefault();

    const id = $('buku-id').value;

    const judul = $('buku-judul').value.trim();
    const penulis = $('buku-penulis').value.trim();

    const polaJudul = /^[\p{L}\p{M}\p{N}\s.,:;'"“”‘’!?()[\]{}&+*#@%/\-–—\\]+$/u;

    const polaPenulis = /^[\p{L}\p{M}]+(?:[ .'-][\p{L}\p{M}]+)*\.?$/u;

    if (judul === '') {
        pesan('Judul buku wajib diisi.', 'warning');
        $('buku-judul').focus();
        return;
    }

    if (!polaJudul.test(judul)) {
        pesan('Judul buku mengandung karakter yang tidak diperbolehkan.', 'warning');
        $('buku-judul').focus();
        return;
    }

    if (penulis === '') {
        pesan('Nama penulis wajib diisi.', 'warning');
        $('buku-penulis').focus();
        return;
    }

    if (!polaPenulis.test(penulis)) {
        pesan('Nama penulis hanya boleh berisi huruf, spasi, titik, tanda hubung, dan apostrof.', 'warning');
        $('buku-penulis').focus();
        return;
    }

    const body = {
        kategori_id: $('buku-kategori_id').value === ''
            ? null
            : Number($('buku-kategori_id').value),

        judul: judul,
        penulis: penulis,

        tahun_terbit: $('buku-tahun_terbit').value === ''
            ? null
            : Number($('buku-tahun_terbit').value),
    };

    $('btn-simpan').disabled = true;

    try {
        await apiRequest(
            id ? `/buku/${id}` : '/buku',
            {
                method: id ? 'PUT' : 'POST',
                body
            }
        );

        pesan(
            id
                ? 'Data buku berhasil diperbarui.'
                : 'Data buku berhasil ditambahkan.'
        );

        kosongkanForm();
        await muatBuku(id ? halaman : 1);

    } catch (err) {
        tanganiError(err);
    } finally {
        $('btn-simpan').disabled = false;
    }
}
async function bukaFormUbah(id) {
    try {
        const { data } = await apiRequest(`/buku/${id}`);
        isiForm(data);
    } catch (err) {
        tanganiError(err);
    }
}

async function hapus(id) {
    if (!confirm('Yakin ingin menghapus buku ini?')) return;

    try {
        await apiRequest(`/buku/${id}`, { method: 'DELETE' });
        pesan('Data buku berhasil dihapus.');
        if ($('buku-id').value === String(id)) kosongkanForm();
        await muatBuku(halaman);
    } catch (err) {
        tanganiError(err);
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    if ($('form-buku')) {
        $('form-buku').onsubmit = simpan;
        $('btn-batal').onclick = kosongkanForm;
    }
    $('btn-prev').onclick = () => muatBuku(halaman - 1);
    $('btn-next').onclick = () => muatBuku(halaman + 1);

    $('tbody-buku').onclick = (e) => {
        const b = e.target.closest('button[data-aksi]');
        if (!b) return;
        if (b.dataset.aksi === 'hapus') hapus(b.dataset.id);
        else bukaFormUbah(b.dataset.id);
    };

    if ($('form-buku')) await muatKategori();
    await muatBuku(1);
});