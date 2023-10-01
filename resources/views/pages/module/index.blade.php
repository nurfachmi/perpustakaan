@extends('layouts.app')

@section('title', $title)

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    <x-datatable :tableId="'modules'" :tableHeaders="['Module Name', 'Enabled', 'Action']" :tableColumns="[['data' => 'name'], ['data' => 'enabled'], ['data' => 'action']]" :getDataUrl="route('datatables.modules')" />
                </div>
            </div>
        </div>
    </div>
@endsection
