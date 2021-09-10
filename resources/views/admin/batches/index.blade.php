@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'MEPTP Batches Management', 'route' => 'batches.index'])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <h2 class=" mb-6">MEPTP Batches Management</h2>
        <hr>
        <a href="{{route('batches.create')}}"><button class="btn btn-primary" type="button">ADD NEW BATCH</button></a>
        <hr>
        @if(!$batches->isEmpty())
        <div class="row">
            @foreach($batches as $batch)
            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="card card-icon mb-4">
                    <a href="{{ $batch->status ? route('batches.show', $batch->id) : '#' }}">
                        <div class="card-body text-center"><i class="i-Students"></i>
                            <p class="text-muted mt-2 mb-2">Batch Number</p>
                            <p class="text-primary text-40 line-height-1 m-0">{{$batch->batch_no}}-{{$batch->year}}</p>
                            <p><span
                                    class="badge badge-pill p-2 m-1 {{ $batch->status ? 'badge-outline-success' : 'badge-outline-danger' }}">
                                    {{ $batch->status ? 'ACTIVE' : 'DISABLED' }}
                                </span></p>
                            <p><span class="badge w-badge {{ $batch->status ? 'badge-success' : 'badge-danger' }}">
                                    {{ $batch->status ? $batch->created_at->format('d-M-Y') : $batch->closed_at->format('d-M-Y')}}
                                </span></p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        {{$batches->links('pagination')}}
        @else
        <span>No batches found</span>
        @endif
    </div>
</div>
@endsection