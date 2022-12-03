@extends('layouts.admin')

@section('titulo')
    <span>Dispositivo</span>

    <a href="" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#createMdl">
        <i class="fas fa-plus"></i>
    </a>
@endsection

@section('contenido')

    @include('products.modals.create')
    @include('products.modals.update')
    @include('products.modals.delete')

    <div class="card">
        <div class="card-body">
            <table id="dt-products" class="table table-striped table-bordered dts">
                <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Ubicacion</th>
                    <th class="text-center">Tipo De Producto</th>
                    <th class="text-center">Serial</th>
                    <th class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($devices as $device)
                    <tr class="text-center">
                        <td>{{$device->id}}</td>
                        <td>{{$device->description}}</td>
                        <td> {{$device->data_volt}}</td>
                        <td>{{$device->data_amp}}</td>
                        <td> {{$device->data_pow}}</td>
                        <td>
                            <a href="" class="edit-form-data" data-toggle="modal" data-target="#editMdl"
                            onclick="editProduct({{--$device--}})">
                                <i class="far fa-edit"></i>
                            </a>

                            <a href="" class="delete-form-data" data-toggle="modal" data-target="#deleteMdl">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('libs/datatables/dataTables.bootstrap4.min.css')}}">
@endpush

@push('scripts')
    <script src="{{asset('/libs/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/libs/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script>
        $(document).ready(function(){
            $("input[name='unit_price'], input[name='quantity']").on('keyup', function () {
                calculateTotalCost(this);
            });
        });

        function editProduct(product){
            $("#editProductFrm").attr('action',`/products/${product.id}`);

            $("#editProductFrm #name").val(product.name);
            $("#editProductFrm #description").val(product.description);
            $("#editProductFrm #unit_price").val(product.unit_price);
            $("#editProductFrm #quantity").val(product.quantity);
            $("#editProductFrm #total_cost").val(product.total_cost);
        }

        function calculateTotalCost(input){
            const formId = input.closest('form').id;
            const unitPrice = $(`#${formId} input[name='unit_price']`);
            const quantity = $(`#${formId} input[name='quantity']`);
            const totalCost = $(`#${formId} input[name='total_cost']`);

            if(unitPrice.val() && quantity.val()){
                totalCost.val(unitPrice.val() * quantity.val());
            }
        }
    </script>

    @if(!$errors->isEmpty())
        @if($errors->has('post'))
            <script>
                $(function () {
                    $('#createMdl').modal('show');
                });
            </script>
        @else
            <script>
                $(function () {
                    $('#editMdl').modal('show');
                });
            </script>
        @endif
    @endif
@endpush
