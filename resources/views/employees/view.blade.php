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
                                                <h4 class="text-uppercase">{{$employee->full_name}}</h4>
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
                                                                {{$employee->emp_id}}
                                                            </p>
                                                            <hr>
                                                            <strong>
                                                                <i
                                                                    class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Employee
                                                                Role
                                                            </strong>
                                                            <p class="text-muted">
                                                                {{$employee->role_name}}
                                                            </p>
                                                            <hr>
                                                            <strong>
                                                                <i
                                                                    class="fa fa-book margin-r-5"></i>&nbsp;&nbsp;Qualification

                                                            </strong>
                                                            <p class="text-muted">
                                                                {{$employee->qualification_text}}
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
                                                    <h5 class="">Contact DETAILS</h5>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span
                                                            style="float:right ;color:blue; font-weight:bold; text-decoration:underline">Phone</span>
                                                        <br />
                                                        <span style="float:right ;font-weight:bold">Phone</span>
                                                    </div>
                                                    <div class="col-md-9">{{$employee->phone}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span
                                                            style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                            Telefon
                                                        </span>
                                                        <br />
                                                        <span style="float:right ;font-weight:bold">Telphone</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{$employee->phone_1}}<br />{{$employee->phone_1}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span
                                                            style="float:right ;color:blue; font-weight:bold; text-decoration:underline">
                                                            E-Mail
                                                        </span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{$employee->emp_email}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span
                                                            style="float:right ;color:blue; font-weight:bold; text-decoration:underline;">Memo</span>
                                                    </div>
                                                    <div class="col-md-3">{{$employee->memo}}</div>

                                                </div>

                                                <hr />
                                                <div>
                                                    <h5 class="">ADDRESS DETAILS</h5>
                                                </div>
                                                <hr />
                                                <div class="row">

                                                    <div class="col-md-3">{{$employee->address}}</div>
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