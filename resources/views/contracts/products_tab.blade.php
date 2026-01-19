<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Contract Product</h4>
                <div class="card-header-action">
                    <input type="button" id="btn_cp_add" value="Add Product" class="btn btn-primary" data-toggle="modal"
                        data-target=".bd-RefClient-modal-lg" />
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tbRefClient">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Tag/Sr. Number</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Branch/Location</th>
                                <th>Remark</th>
                                <th>Service Period</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->count() == 0)
                                <tr>
                                    <td colspan="10" class="text-center">No
                                        products
                                        added yet.</td>
                                </tr>
                            @endif
                            @foreach ($products as $index => $product)
                                <tr>
                                    <td>
                                        {{ $index + 2 }}
                                    </td>
                                    <td>
                                        {{ $product->product_name }}
                                    </td>
                                    <td>{{ $product['type_name'] }}</td>
                                    <td>{{ !empty($product['nrnumber']) ? $product['nrnumber'] : 'N/A' }}</td>
                                    <td>{{ $product['product_description'] }}</td>
                                    <td>{{ $product['product_price'] }}</td>
                                    <td>{{ $product['branch'] }}</td>
                                    <td>{{ $product['remark'] }}</td>
                                    <td>{{ $product['service_period'] }}</td>
                                    <td><a href="#" data-toggle="modal" id="showEditModal"
                                            data-product_name="{{ $product['product_name'] }}"
                                            data-product_type="{{ $product['product_type'] }}"
                                            data-nrnumber="{{ $product['nrnumber'] }}"
                                            data-product_description="{{ $product['product_description'] }}"
                                            data-product_price="{{ $product['product_price'] }}"
                                            data-branch="{{ $product['branch'] }}"
                                            data-remark="{{ $product['remark'] }}"
                                            data-service_period="{{ $product['service_period'] }}"
                                            data-cid="{{ $product['contactId'] }}"
                                            data-product_id="{{ $product['id'] }}"
                                            class="btn btn-icon btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                        <a type="submit" href="{{ route('contract_product.delete', $product['cup_id']) }}"
                                            class="delete-btn btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
