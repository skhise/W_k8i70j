<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $update ? 'Update Invoice Item' : 'Add Invoice Item'}}</h4>
                            </div>
                            <div class="card-body">
                                <form id="frmcreateemployee" method="post" enctype="multipart/form-data"
                                    action="{{$update ? route('invoice-item-update',$invoice_item->id) : route('invoice-item-store')}}">
                                    @csrf
                                    @if(!$update)
                                    <input type="hidden" id="created_by" name="created_by"
                                        value="{{Auth::user()->id}}" />
                                    @endif
                                    <input type="hidden" id="updated_by" name="updated_by"
                                        value="{{Auth::user()->id}}" />
                                    <input type="hidden" id="account_id" name="account_id"
                                        value="{{Auth::user()->account_id}}" />
                                    <div class="form-horizontal">

                                        <h3 style="color:orangered"></h3>


                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h4><i class="fa fa-user"></i> Invoice Item Information</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span
                                                        style="color:blue; font-weight:bold; text-decoration:underline">Description
                                                    </span>
                                                    <br />
                                                    <span style="font-weight:bold">Description</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <textarea
                                                        class="form-control text-box single-line @error('description') is-invalid @enderror"
                                                        data-val="true" id="description" name="description" rows="4"
                                                        placeholder="Description *" required="required"
                                                        type="text">{{old('description') ?? $invoice_item->description}}</textarea>
                                                    @if($errors->has('description'))
                                                    <span class="text-danger field-validation-valid"
                                                        data-valmsg-for="description" data-valmsg-replace="true">{{
                                                        $errors->first('description') }}</span>

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="card-footer text-right">
                                                <input type="button" id="btnAddEmployee"
                                                    value="{{$update ? 'Update' :'Save'}}" class="btn btn-primary">
                                                <a type="button" class="btn btn-primary"
                                                    href="{{route('clients')}}">Back</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @section('script')
    <script>
        $("input[type = 'text']").each(function () {
            $(this).change(function () {
                $(this).removeClass('is-invalid');
                $(this).siblings('span').text('');
            });
        });
        $('#btnAddEmployee').on('click', function () {
            $("#frmcreateemployee")[0].submit();
        });
    </script>

    @stop
</x-app-layout>