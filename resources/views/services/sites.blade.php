<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Clients</h4>
                                <div class="card-header-action">

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #Code
                                                </th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Website </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($sites) == 0)
                                            <tr>
                                                <td colspan="6" class="text-center">No sites to show</td>
                                            </tr>
                                            @endif
                                            @foreach($sites as $site)
                                            <tr>
                                                <td>
                                                    1
                                                </td>
                                                <td>Create a mobile app</td>
                                                <td class="align-middle">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-success width-per-40">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <img alt="image" src="assets/img/users/user-5.png" width="35">
                                                </td>
                                                <td>2018-01-20</td>
                                                <td>
                                                    <div class="badge badge-success badge-shadow">Completed</div>
                                                </td>
                                                <td><a href="#" class="btn btn-primary">Detail</a></td>
                                            </tr>
                                            @endforeach


                                        </tbody>
                                        <tfooter>
                                            {{ $sites->links() }}
                                        </tfooter>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</x-app-layout>