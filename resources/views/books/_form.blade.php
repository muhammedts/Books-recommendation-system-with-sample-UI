@csrf

<div class="row g-3">
    <div class="col-md-8">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" maxlength="500" required
               class="form-control @error('title') is-invalid @enderror">
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label for="isbn" class="form-label">ISBN <span class="text-body-secondary small">(optional)</span></label>
        <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}" maxlength="20"
               class="form-control @error('isbn') is-invalid @enderror">
        @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-8">
        <label for="authors" class="form-label">Authors</label>
        <input type="text" name="authors" id="authors" value="{{ old('authors', $book->authors) }}" maxlength="1000" required
               class="form-control @error('authors') is-invalid @enderror" placeholder="Separate multiple authors with commas">
        @error('authors')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-2">
        <label for="original_publication_year" class="form-label">Year</label>
        <input type="number" name="original_publication_year" id="original_publication_year"
               value="{{ old('original_publication_year', $book->original_publication_year) }}"
               class="form-control @error('original_publication_year') is-invalid @enderror">
        @error('original_publication_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-2">
        <label for="language_code" class="form-label">Language</label>
        <input type="text" name="language_code" id="language_code" value="{{ old('language_code', $book->language_code) }}"
               maxlength="16" placeholder="eng" class="form-control @error('language_code') is-invalid @enderror">
        @error('language_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="cover" class="form-label">Upload a cover</label>
        <input type="file" name="cover" id="cover" accept="image/*"
               class="form-control @error('cover') is-invalid @enderror">
        @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label for="image_url" class="form-label">&hellip;or use a cover URL</label>
        <input type="url" name="image_url" id="image_url" placeholder="https://"
               value="{{ old('image_url', $book->hasUploadedCover() ? '' : $book->image_url) }}"
               class="form-control @error('image_url') is-invalid @enderror">
        @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    @if ($book->exists && $book->image_url)
        <div class="col-12 d-flex align-items-center gap-3">
            <img src="{{ $book->cover_url }}" alt="Current cover" class="rounded border" style="height: 90px">
            <span class="text-body-secondary small">Current cover. Leave both cover fields empty to keep it.</span>
        </div>
    @endif
</div>
