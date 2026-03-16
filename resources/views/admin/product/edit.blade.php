@extends('admin.layout.app')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">

            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <form method="post" action="{{ route('product-update') }}" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $data->id }}">

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror" id=""
                                                placeholder="Enter Gold Name" value="{{ $data->name }}" />

                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Weight</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="number" name="weight"
                                                class="form-control @error('weight') is-invalid @enderror" id=""
                                                placeholder="Enter Rate Weight" value="{{ $data->weight }}" />

                                            @error('rate')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Purity</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="number" name="purity"
                                                class="form-control @error('purity') is-invalid @enderror" id=""
                                                placeholder="Enter Rate purity" value="{{ $data->purity }}" />

                                            @error('rate')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Purity</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="number" name="purity"
                                                class="form-control @error('purity') is-invalid @enderror" id=""
                                                placeholder="Enter Rate purity" value="{{ $data->purity }}" />

                                            @error('rate')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Product Content</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <textarea class="form-control" id="input11" name="content" placeholder="Product Content ..." rows="3">{{ $data->content }}</textarea>

                                            @error('content')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Product Category</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <select id="input7" name="category" class="form-select">
                                                <option value="">Choose
                                                    Category</option>
                                                <option value="Gold" {{ $data->category === 'Gold' ? 'selected' : '' }}>
                                                    Gold</option>
                                                <option value="Silver"
                                                    {{ $data->category === 'Silver' ? 'selected' : '' }}>Silver</option>
                                            </select>

                                            @error('category')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Gold Rate</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <select class="form-select mb-3" aria-label="Default select example"
                                                name="rate_id">
                                                @foreach ($rates as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $data->rate_id ? 'selected' : '' }}>
                                                        {{ $item->name }} = Rs.
                                                        {{ $item->amount }} </option>
                                                @endforeach


                                            </select>

                                            @error('rate_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Product Image</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="file" name="image" class="form-control" id="image" />
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0"> </h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <img id="showImage" src="{{ asset($data->image) }}" alt="Admin"
                                                style="width:100px; height: 100px;">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="submit" class="btn btn-primary px-4" value="Update Product" />
                                        </div>
                                    </div>



                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
