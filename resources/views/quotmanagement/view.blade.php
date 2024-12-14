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
                                        <a class="btn btn-info" target="_blank"
                                            href="{{ route('quotmanagements.print', $quotation->dcp_id) }}">Print</a>
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
                                                        <span style="font-weight:bold">Quotation
                                                            No.: {{ $quotation->id }}</span>
                                                    </div>
                                                    <!-- <div class="col-md-3">
                                                        <span style="font-weight:bold">Quotation Type:
                                                            {{ $quotation->quot_type_name }}</span>
                                                    </div> -->
                                                    <div class="col-md-2">
                                                        <span style="float:right ;font-weight:bold">Current Status:
                                                            {{ $quotation->status_name }}</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <span style="float:right ;font-weight:bold;display:flex;" class="flex">
                                                        <label>Change Status:</label>
                                                        <select id="change_status" name="change_status" class="form-control">
                                                           <option value="">Select Status</option>
                                                            @foreach ($qStatus as $status)
                                                                <option value="{{ $status->id }}" {{$status->id == $quotation->quot_status ? 'selected':'' }}>
                                                                    {{ $status->status_name }}</option>
                                                            @endforeach
                                                           </select>      
                                                    </span>
                                                          
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
            $(document).on('change', '#change_status', function() {
                var value = $(this).val();
                if (value != "") {
                   $.ajax({
                        type:'GET',
                        url:'status-update'+"/"+value,
                        success:function(status){
                            if(status){
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Saved!',
                                    dangerMode: true,
                                    icon: 'success',
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                });
                                window.location.reload();
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Someting went wrong, try again',
                                    dangerMode: true,
                                    icon: 'error',
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                });
                            }
                        },
                        error:function(error){
                            Swal.fire({
                                    title: 'Error!',
                                    text: 'Someting went wrong, try again',
                                    dangerMode: true,
                                    icon: 'error',
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                });
                        }
                   });
                }
            });
        </script>
    @stop
</x-app-layout>
