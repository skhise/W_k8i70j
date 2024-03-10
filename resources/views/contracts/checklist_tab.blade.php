<div class="row">
                                            <div class="col-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4>CheckList</h4>
                                                        <div class="card-header-action">
                                                            <input type="button" id="btn_checklist_add" value="Add Note"
                                                                class="btn btn-primary" data-toggle="modal"
                                                                data-target=".bd-RefChecklist-modal-lg" />
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped" id="tbRefChecklist">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr. No.</th>
                                                                        <th style="width:80%;">Description</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if($checklists->count() == 0)
                                                                    <tr>
                                                                        <td colspan="3" class="text-center">No
                                                                            checklist
                                                                            added yet.</td>
                                                                    </tr>
                                                                    @endif
                                                                    @foreach($checklists as $index => $checklist)
                                                                    <tr>
                                                                        <td>
                                                                            {{$index + 1}}
                                                                        </td>
                                                                        <td>{{$checklist['description']}}</td>
                                                                        <td><a href="#" data-toggle="modal"
                                                                                id="showChkEditModal"
                                                                                data-description="{{$checklist['description']}}"
                                                                                data-cid="{{$checklist['contactId']}}"
                                                                                data-id="{{$checklist['id']}}"
                                                                                class="btn btn-icon btn-sm btn-primary"><i
                                                                                    class="far fa-edit"></i></a>
                                                                                <a type="submit" href="{{route('checklist.delete', $checklist['id'])}}" class="btn btn-sm btn-danger"><i
                                                                                    class="fa fa-trash"></i></a</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>