<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Quotation Details</h4>
                                <div class="card-header-action">
                                    @if ($flag == 1)
                                        <a class="btn btn-danger" href="{{ route('quotation-report') }}">Back</a>
                                    @else
                                        <a class="btn btn-danger" href="{{ route('quotmanagements') }}">Back</a>
                                    @endif
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-success">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="font-weight:bold">DC
                                                            No.: {{ $quotation->id }}</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span style="font-weight:bold">DC Type:
                                                            {{ $quotation->dc_type_name }}</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span style="float:right ;font-weight:bold">Service
                                                            No.:{{ $quotation->service_no }}</span>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <span style="font-weight:bold">Client Name :
                                                            {{ $quotation->CST_Name }}</span>
                                                    </div>

                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <span style="font-weight:bold">Description</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{ $quotation->Product_Description }}
                                                    </div>
                                                </div>
                                            </div>

                                            @include('quotmanagement.quot_product')
                                            <hr />
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    @section('script')
        <script>
            $(document).on('change', '#Image_Path', function() {
                var value = $(this).val();
                if (value != "") {
                    $('#image_upload')[0].submit();
                }
            });
        </script>
    @stop
</x-app-layout>
