@extends('admin.layout.app')
@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Admin</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Category</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th> Rate </th>
                                <th> Name </th>
                                <th> Weight </th>
                                <th> Purity </th>
                                <th> Category </th>
                                <th> Price </th>
                                <th> Image </th>
                                <th> Status </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $key => $item)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td>{{ $item->rate_id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->weight }}</td>
                                    <td>{{ $item->purity }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td> <img src="{{ asset($item->image) }}" style="width: 70px; height:40px;">
                                    </td>
                                    <td>
                                        @if ($item->status == 1)
                                            <span class="badge badge-pill bg-success">Active</span>
                                        @else
                                            <span class="badge badge-pill bg-danger">InActive</span>
                                        @endif


                                    </td>
                                    <td>
                                        <a href="{{ route('product-edit', $item->id) }}" class="btn btn-info">Edit</a>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl</th>
                                <th> Rate </th>
                                <th> Name </th>
                                <th> Weight </th>
                                <th> Purity </th>
                                <th> Category </th>
                                <th> Price </th>
                                <th> Image </th>
                                <th> Status </th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>



    </div>
@endsection
