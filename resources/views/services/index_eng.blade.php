<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <h4>Services</h4>
                                @if (auth()->user()->role == 1)
                                    <a href="{{ route('services.create') }}" class="btn btn-icon icon-left btn-primary">
                                        <i class="fas fa-plus-square"></i> Add Service
                                    </a>
                                @endif
                            </div>

                            <div class="card-body">
                                {{-- Search Form --}}
                                <form action="{{ route('services') }}" id="search_form_all" class="mb-3" method="GET">
                                                                       {{-- Top Search Bar --}}
                                    <div class="mb-3">
                                        <input type="text" name="search_field" id="top_search" class="form-control"
                                            placeholder="Search"
                                            value="{{ request('search_field') }}" />
                                    </div>

                                    {{-- Existing filters go here (not shown for brevity) --}}
                                </form>
                                {{-- Mobile View --}}
                                <div class="d-block" style="max-height: 600px; overflow-y: auto;">
                                    @forelse ($services as $service)
                                            <div class="card mb-3 shadow-sm border rounded px-3 py-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                {{-- Left side: Icon + Content --}}
                                                <div class="d-flex align-items-start  align-items-center">
                                                    <div class="mr-3">
                                                        <i class="fa fa-ticket-alt fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 font-weight-bold">{{ $service['service_no'] }}</h6>
                                                        
                                                        <div class="small">
{{ $service['CST_Name'] }}
                                                            
                                                        </div>
                                                        <div class="text-muted small mt-1">
                                                            <i class="far fa-calendar-alt"></i>
                                                            {{ $service['service_date'] ? date('d M Y', strtotime($service['service_date'])) : 'NA' }}
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Right side: View Button --}}
                                                <div class="d-flex align-items-center">
                                                    <span
                                                                class="font-weight-bold {{ $service['status_color'] }} text-white p-1 rounded">{{ $service['Status_Name'] }}</span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    
                                                    <a href="{{ route('services.view', $service['service_id']) }}"
                                                        class="btn btn-outline-primary d-flex align-items-center justify-content-center"
                                                        title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    @empty
                                        <p class="text-center">No tickets found</p>
                                    @endforelse
                                </div>
                                {{-- Pagination --}}
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        @if ($services->total())
                                            <p>Found {{ $services->total() }} records</p>
                                        @endif
                                    </div>
                                    <div>
                                        {{ $services->links() }}
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
        $(document).on('change', '#top_search', function(e) {
            e.preventDefault();
                $('#search_form_all').submit();
        });
        $(document).on('click', '.btn-status-filter', function () {
            $("#filter_status").val($(this).data("key"));
            $("#search_form_all")[0].submit();
        });
        $(document).on('change', '#dayFilter', function () {
            $("#search_form_all")[0].submit();
        });
        $(document).on('click', ".dropdown-item", function () {
            $(".dropdown-item").removeClass("active");
            var text = $(this).text();
            if (text == "All") {
                $("#search_field").val("");
                $("#search").attr("placeholder", "Search");
            } else {
                $("#search_field").val($(this).data("field"));
                $("#search").attr("placeholder", "Search by " + text);
            }
            $(this).addClass('active');
            if ($("#search").val() != "") {
                $("#search_form_all")[0].submit();
            }
        });

        // Trigger search on Enter in top search bar
        $(document).on('keypress', '#top_search', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#search_form_all').submit();
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
            $(".filter-remove").click(function (e) {
                e.preventDefault();
                $("#search_field").val("");
                $("#filter_type").val("");
                $("#filter_service_type").val("");
                $("#filter_issue_type").val("");
                $("#filter_status_type").val("");
                $("#search").val("");
                $("#filter_status").val("");
                $("#dayFilter").val("180");
                window.location.replace("services");
            });
        });
    </script>
    @stop
</x-app-layout>