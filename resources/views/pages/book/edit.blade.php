@extends('layouts.app')

@section('title', $title)

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
                <a href="{{ route('books.index') }}" class="d-none d-sm-inline-block btn btn-outline-primary shadow-sm">
                    Back
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('books.update', $book->getKey()) }}" method="post">
                        @csrf @method('PUT')
                       <div class="form-group row">
                            <label for="isbn" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">

                                <div id="reader" width="300px"></div>
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="isbn" class="col-sm-2 col-form-label">ISBN</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                                    name="isbn" id="isbn" value="{{ $book->isbn }}" placeholder="ISBN">
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <p>
                            <a class="btn btn-primary" id="data-buku" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Masukan Data Buku
                            </a>
                            </p>
                            <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                 <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="title" id="title" value="{{$book->title }}" placeholder="Title">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="author" class="col-sm-2 col-form-label">Author</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('author') is-invalid @enderror"
                                    name="author" id="author" value="{{ $book->author }}" placeholder="Author">
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('author') is-invalid @enderror"
                                    name="category" id="category" value="{{ old('category') }}" placeholder="Category">
                                    @foreach($category as $value):
                                        @if($value->id == $book->category_id):
                                        <option value="{{$value->id}}" selected>{{$value->category_name}}</option>
                                        @else
                                        <option value="{{$value->id}}">{{$value->category_name}}</option>
                                        @endif
                                    @endforeach;
                                </select>
                            </div>

                            <div class="form-group row mt-2">
                            <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                        </div>
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
