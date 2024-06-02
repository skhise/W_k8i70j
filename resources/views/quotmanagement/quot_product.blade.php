<div class="row m-3">
    <div class="col-12">
        <div class="table-responsive">
            <h4>Products</h4>
            <hr />
            <table class="table table-striped" id="tbRefClient">

                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Name</th>
                        <th>Serial No.</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($products->count() == 0)
                        <tr>
                            <td colspan="7" class="text-center">No
                                serial number added yet.</td>
                        </tr>
                    @endif
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>
                                {{ $index + 1 }}
                            </td>
                            <td>
                                {{ $product->Product_Name }}
                            </td>
                            <td>
                                {{ $product->sr_number }}
                            </td>
                            <td>
                                {{ $product->type_name }}
                            </td>
                            <td>
                                {{ $product->amount }}
                            </td>
                            <td>
                                {{ $product->description }}
                            </td>
                            <td>
                                <a href="{{ route('quotmanagements.delete_qp', $product['sdp']) }}"
                                    class="delete-btn btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" style="text-align:right;"><strong>DC Total</strong></td>
                        <td colspan="3" style="text-align:left;">
                            <strong>
                                Rs.
                                {{ $products->sum(function ($product) {return $product->amount;}) }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
