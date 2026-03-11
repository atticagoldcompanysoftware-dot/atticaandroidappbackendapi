@extends('admin.layout.app')
@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Product</li>
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

                                <form method="post" action="{{ route('product-store') }}" enctype="multipart/form-data">
                                    @csrf


                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Product Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror" id=""
                                                placeholder="Enter Product Name" />

                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Product Weight</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="weight"
                                                class="form-control @error('weight') is-invalid @enderror" id=""
                                                placeholder="Enter Product Weight" />

                                            @error('weight')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Product Purity</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="purity"
                                                class="form-control @error('purity') is-invalid @enderror" id=""
                                                placeholder="Enter Product Purity" />

                                            @error('purity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Product Content</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <textarea class="form-control" id="input11" name="content" placeholder="Product Content ..." rows="3"></textarea>

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
                                                <option selected>Choose Category</option>
                                                <option value="Gold">Gold</option>
                                                <option value="Silver">Silver</option>
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
                                                <option selected="">Choose the Gold Rate</option>
                                                @foreach ($rates as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }} =
                                                        {{ $item->amount }} Rs.</option>
                                                @endforeach

                                            </select>

                                            @error('gold_id')
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

                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="submit" class="btn btn-primary px-4" value="Add Gold Rate" />
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
@endsection
