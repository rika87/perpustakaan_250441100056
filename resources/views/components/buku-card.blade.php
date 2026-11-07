@props(['buku'])

<div class="book-card">

    <div class="book-content">

        <span class="book-category">
            {{ $buku->kategori->nama }}
        </span>

        <h3>{{ $buku->judul }}</h3>

        <p class="author">
            {{ $buku->penulis }}
        </p>

        <div class="book-info">
            <span>Tahun terbit</span>
            <strong>{{ $buku->tahun_terbit }}</strong>
        </div>

        <div class="book-footer">
            <span>ID: {{ $buku->id }}</span>

            <a href="{{ route('components.buku.show', $buku->id) }}" class="detail-btn">
                Detail
            </a>
        </div>

    </div>

</div>