<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Products</h4>
                                <div class="card-header-action">
                                    <a href="{{route('products.create')}}" class="btn btn-icon icon-left btn-primary"><i
                                            class="
                                        fas fa-plus-square"></i>
                                        Add Product</a>

                                </div>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form action="{{route('products')}}" id="search_form">
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{$search}}" id="search"
                                                name="search" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary filter-dropdown"
                                                    data-toggle="dropdown"><i class="fas fa-filter"></i></button>
                                                <button class="filter-remove_btn btn btn-danger ml-2">
                                                            <i class="fa fa-times"></i></button>
                                                <div class="edit-filter-modal dropdown-menu-right hidden">
                                                    <li class="dropdown-title">Filter By</li>
                                                    <select class="mt-2 select2" name="filter_type" id="filter_type">
                                                        <option value="" >Product Type</option>
                                                        @foreach($product_type as $ptype)
                                                            <option value="{{$ptype->id}}" {{$ptype->id == $filter_type ? 'selected':''}}>{{$ptype->type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <br />

                                                    <button type="submit"
                                                        class="mt-2 ml-2 apply-button btn btn-primary btn-sm">Apply</button>
                                                    <button type="button"
                                                        class="mt-2 filter-remove btn btn-danger btn-sm">Cancel</button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>Name</th>
                                                <th>Product Type</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($products) == 0)
                                            <tr class="text-center">
                                                <td colspan="6">No products added yet.</td>
                                            </tr>
                                            @else
                                            @foreach($products as $index => $product)
                                            <tr key="{{$product['Product_ID']}}">
                                                <td>{{$index + 1}}</td>
                                                <td>{{$product['Product_Name']}}</td>
                                                <td>{{$product['type_name']}}</td>
                                                <td title="{{$product['Product_Description']}}">{!!
            Str::limit($product['Product_Description'], 50, ' ...') !!}
                                                </td>
                                                <td>
                                                    <div class="">
                                                    <a href="{{route('products.view', $product['Product_ID'])}}"
                                                        class="action-btn btn btn-icon btn-sm btn-primary"><i
                                                            class="far fa-eye"></i></a>
                                                    
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                    <div class="float-left">
                                        @if($products->total())
                                        <p>Found {{ $products->total()}} records</p>
                                        @endif
                                    </div>
                                    <div class="float-right">
                                        {{ $products->links() }}
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
        $(document).on('change', '#search', function () {
            $("#search_form")[0].submit();
        })
        $(document).on('click', ".dropdown-item", function () {
            $(".dropdown-item").removeClass("active");
            var text = $(this).text();
            if (text == "All") {
                $("#search_field").val("");
                // $("#search").val("");
                $("#search").attr("placeholder", "Search");
            } else {
                $("#search_field").val($(this).data("field"));
                $("#search").attr("placeholder", "Search by " + text);
            }
            $(this).addClass('active');
            if ($("#search").val() != "") {
                $("#search_form")[0].submit();
            }
        });
        $(document).ready(function () {
            $(".filter-dropdown, .text-button").click(function () {
                $(".edit-filter-modal").toggleClass("hidden");

            });
            $(".apply-button").click(function () {
                $(".edit-filter-modal").toggleClass("hidden");
                $(".filter, .fa-plus, .fa-filter").toggleClass("filter-hidden");
                $(".filter-dropdown-text").text("Add filter");
            });

            $(".filter-remove").click(function () {
                $("#search_field").val("");
                $("#search").val("");
                $("#filter_type").val("");
                window.location.replace("products");
                $(".edit-filter-modal").toggleClass("hidden");
            });
            $(".filter-remove_btn").click(function (e) {
                e.preventDefault();
                $("#search_field").val("");
                $("#search").val("");
                $("#filter_type").val("");
                window.location.replace("products");
            });




        });
    </script>

    @stop
</x-app-layout>