<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Employee Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="text-uppercase">{{$employee->EMP_Name}}</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group ">
                                                    <li class="list-group-item">
                                                        <div class="box-body">
                                                            <strong>
                                                                <i
                                                                    class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Employee
                                                                ID
                                                            </strong>
                                                            <p class="text-muted">
                                                                {{$employee->EMP_ID}}
                                                            </p>
                                                            <hr>
                                                            <strong>
                                                                <i
                                                                    class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Employee
                                                                Role
                                                            </strong>
                                                            <p class="text-muted">
                                                                {{$employee->access_role_name}}
                                                            </p>
                                                            <hr>
                                                            <strong>
                                                                <i
                                                                    class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Qualification

                                                            </strong>
                                                            <p class="text-muted">
                                                                {{$employee->EMP_Qualification}}
                                                            </p>
                                                            <hr>
                                                            <strong>
                                                                <i class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Status
                                                            </strong>
                                                            <p>{!!$status[$employee['status']]!!}</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <br />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card card-success">
                                            <div class="card-body">
                                                <div>
                                                    <h class="">CONTACT DETAILS</h5>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="float:right ;font-weight:bold">Mobile</span>
                                                    </div>
                                                    <div class="col-md-9">{{$employee->EMP_MobileNumber}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="float:right ;font-weight:bold">Alt Mobile</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{$employee->EMP_CompanyMobile}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="float:right ;font-weight:bold;">
                                                            E-Mail
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{$employee->EMP_Email}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span style="float:right ; font-weight:bold;">Technical
                                                            Abilities</span>
                                                    </div>
                                                    <div class="col-md-3">{{$employee->EMP_TechnicalAbilities}}</div>

                                                </div>

                                                <hr />
                                                <div>
                                                    <h5 class="">ADDRESS DETAILS</h5>
                                                </div>
                                                <hr />
                                                <div class="row">

                                                    <div class="col-md-3">{{$employee->EMP_Address}}</div>
                                                </div>
                                                <hr />
                                            </div>
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
</x-app-layout>