<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Master Settings</h4>
                            </div>
                            <div class="card-body">
                                <div class="col-lg-4">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-header">
                                            Masters
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item clickMenu"
                                                data-route="{{route('masters.contract-type')}}">
                                                <i class="fa fa-info"></i><a class="btn"
                                                    href="masters/contract-type">Contract
                                                    Type</a>
                                            </li>
                                            <li class="list-group-item clickMenu"
                                                data-route="{{route('masters.product-type')}}"><i
                                                    class="fa fa-info"></i><a class="btn icon-btn"
                                                    href="masters/product-type">Product
                                                    Type</a>
                                            </li>
                                            <li class="list-group-item clickMenu"
                                                data-route="{{route('masters.site-area')}}"><i class="fa fa-info"></i><a
                                                    class="btn" href="masters/site-area">Site
                                                    Location</a></li>
                                            <li class="list-group-item clickMenu"
                                                data-route="{{route('masters.service-sub-status')}}"><i class="fa fa-info"></i><a
                                                    class="btn" href="{{route('masters.service-sub-status')}}">Service Sub Status
                                                    </a></li>
                                        </ul>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                @section('script')
                <script>
                    $(document).on("click", ".clickMenu", function () {
                        var route = $(this).data('route');
                        window.location.replace(route);
                    });
                </script>
                @stop
</x-app-layout>