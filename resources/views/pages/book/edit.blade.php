@extends('layouts.app')

@section('title', $title)

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
                <a href="{{ route('books.index') }}" class="d-none d-sm-inline-block btn btn-outline-primary shadow-sm">
                    Kembali
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('books.update', $book->getKey()) }}" method="post">
                        @csrf @method('PUT')

                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">
                                Judul Buku
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="title" id="title" value="{{ old('title', $book->title) }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_id" class="col-sm-2 col-form-label">
                                Kategori
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-10">
                                <select class="form-control @error('author') is-invalid @enderror" name="category_id"
                                    id="category_id" value="{{ old('category_id') }}">
                                    <option value="">Pilih kategori</option>
                                    @foreach ($category as $value)
                                        <option value="{{ $value->id }}" @selected(old('category_id', $book->category_id) == $value->id)>{{ $value->category_name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="author" class="col-sm-2 col-form-label">
                                Penulis
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('author') is-invalid @enderror"
                                    name="author" id="author" value="{{ old('author', $book->author) }}">
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="publish_year" class="col-sm-2 col-form-label">
                                Tahun Terbit
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('publish_year') is-invalid @enderror"
                                    name="publish_year" id="publish_year" value="{{ old('publish_year', $book->publish_year) }}">
                                @error('publish_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-2 col-form-label">Sinopsis</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                    rows="3">{{ old('description', $book->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="isbn" class="col-sm-2 col-form-label">ISBN</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                                    name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}" placeholder="ISBN"
                                    aria-describedby="isbnId" readonly>
                                <small id="isbnId" class="form-text text-muted">ISBN tidak bisa diubah kembali.</small>
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-2">
                            <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Ubah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
 <script src="https://unpkg.com/html5-qrcode"></script>
 <script>


        if ($("#isbn").val() != ''){

            $("#data-buku").removeClass("disabled")
        } else {

            $("#data-buku").addClass("disabled")
        }

        $("#isbn").on("input",function (e) {
         if (e.target.value != ''){

            $("#data-buku").removeClass("disabled")
        } else {

            $("#data-buku").addClass("disabled")
        }
        })

        function onScanSuccess(decodedText, decodedResult) {
        $("#isbn").val(decodedText)
        $("#data-buku").toggleClass("disabled")
        }


        function onScanFailure(error) {
        console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);


    </script>
    @endsection
