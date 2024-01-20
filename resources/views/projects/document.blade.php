<?php
function getContent($index_main,$contents,$heading_title,$headings_id,$heading_selected_content){
   $li = "";
    $ckeid = "heading_".$headings_id."_summernote"; 
    foreach($contents as $key => $content){
        $sub_ul="";
        if(isset($content->sub_content)){
            $sub_li = "";
            foreach($content->sub_content as $index => $subcontent) {
                $sub_content_titless  = str_replace(' ','',$heading_title)."_sub_".$subcontent->id;
                $sub_li .= '<li  style="list-style-type:none;" class="heading_{{$headings_id}}_search"><div class="custom-checkbox custom-control">
        <input data-headingid="'.$content->id.'" data-subHeading="<span style=background: #edefef;margin-top: 5px;margin-right: 10px;><strong>"'.$content->content_details.'"</strong></span>" type="checkbox" data-tag="child" name="heading_checkbox["'.$content->id.'"]"  data-ckeid="'.$ckeid.'" data-checkboxes="mygroup" class="content_checkbox custom-control-input"
          id="'.$sub_content_titless.'" value="'.$subcontent->content_details.'">
        <label for="'.$sub_content_titless.'" class="custom-control-label">&nbsp;'.$subcontent->content_details.'</label>&nbsp;&nbsp;'.$subcontent->option.' 
      </div></li>';
            }
            $sub_ul ="<ul class='collapse' style='padding-left:0px;' id='heading_".$content->id."_content_mycard-collapse'>".$sub_li."</ul>";
        }
        $sub_content_title  = str_replace(' ','',$heading_title)."_".$key;

        $li .= '<li style="list-style-type:none;" class="heading_{{$headings_id}}_search">
        <div class="row" style="background: #edefef;margin-top: 5px;margin-right: 10px;">
        <span style="flex: auto;" for="'.$sub_content_title.'">&nbsp;<strong>'.$content->content_details.'</strong></span>
        <a data-collapse="#heading_'.$content->id.'_content_mycard-collapse" class="btn btn-icon content_mycard-collapse" href="#"><i class="fas fa-plus"></i></a>
      </div></li>'.$sub_ul;
    }
    $ul ="<ul style='width: 100%;'>".$li."</ul>";

    return $ul;
}
function getContentPop($index_main,$contents,$heading_title,$headings_id,$heading_selected_content){
    $li = "";
     $ckeid = "heading_".$headings_id."_summernote";
     foreach($contents as $key => $content){
         $sub_ul="";
         if(isset($content->sub_content)){
             $sub_li = "";
             foreach($content->sub_content as $index => $subcontent) {
                 $sub_content_titless  = str_replace(' ','',$heading_title)."_sub_".$subcontent->id;
                 $sub_li .= '<li  style="list-style-type:none;" class="heading_{{$headings_id}}_search"><div class="custom-checkbox custom-control">
         <input data-headingid="'.$content->id.'" data-subHeading="<span style=\'margin-bottom: 15px;margin-right: 10px;\'><strong>'.$content->content_details.'</strong></span>" type="checkbox"  name="heading_checkbox['.$content->id.']" data-tag="child"  data-ckeid="'.$ckeid.'" data-checkboxes="mygroup" class="content_checkbox custom-control-input"
           id="'.$sub_content_titless.'" value="'.str_replace('"', '', $subcontent->content_details).'">
         <label for="'.$sub_content_titless.'" class="custom-control-label">&nbsp;'.str_replace('"', '', $subcontent->content_details).'</label>&nbsp;&nbsp;'.$subcontent->option.' 
       </div></li>';
             }
             $sub_ul ="<ul class='collapse' style='padding-left:0px;' id='heading_".$content->id."_content_mycard-collapsepop'>".$sub_li."</ul>";
         }
         $sub_content_title  = str_replace(' ','',$heading_title)."_".$key;
         $toggle_btn = count($content->sub_content) != 0 ? '<a data-collapse="#heading_'.$content->id.'_content_mycard-collapsepop" class="btn btn-icon content_mycard-collapse" href="#"><i class="fas fa-plus"></i></a>' : '';
         $li .= '<li style="list-style-type:none;" class="heading_{{$headings_id}}_search">
         <div class="row" style="background: #edefef;margin-top: 5px;margin-right: 10px;">
         <span style="flex: auto;" for="'.$sub_content_title.'">&nbsp;<strong>'.$content->content_details.'</strong></span>'.$toggle_btn.'
            </div></li>'.$sub_ul;
     }
     $serach = "";
     $editor = "";
     if($headings_id == 8 || $headings_id == 9 || $headings_id == 10){
         $serach ='<input type="text" name="search"
         class="form-control search_inside_list mr-2"
         data-search="heading_'.$headings_id.'_search"
         placeholder="Search">';
        $editor = '<div class="row">
        <div style="width:100%;">
            <button type="button" class="btn btn-primary pull-right mr-2" id="btn-save-change" data-noteid="heading_'.$headings_id.'_summernote">Update Changes</button>
        </div>
        <div class="col-lg-12 mt-2">
            <textarea
                style="height:65vh;"
                id="heading_'.$headings_id.'_summernotepop"
                class="summernote heading_'.$headings_id.'_summernote ">'.$heading_selected_content.'</textarea>
        </div>
 
    </div>'; 
     $html="<div class='row'><div class='col-lg-6'>".$serach."<ul style='width: 100%;overflow-y:scroll;height:70vh;'>".$li."</ul></div><div class='col-lg-6'>".$editor."</div></div>";
     return $html;
     }
     $ul ="<ul style='width: 100%;'>".$li."</ul>";
 
     return $ul;
 }
?>
<style>
    .card .card-body {
        padding-top: 10px !important;
        padding-bottom: 15px !important;
    }
</style>

<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Project Documents</h4>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab2" data-toggle="tab"
                                            href="#ProjectPrufingDocument" role="tab" aria-controls="home"
                                            aria-selected="true">Prufing Document</a>
                                    </li>

                                </ul>
                                <div class="tab-content tab-bordered">
                                    <div class="tab-pane fade show active" id="ProjectPrufingDocument" role="tabpanel"
                                        aria-labelledby="profile-tab3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4 class="text-uppercase">
                                                            {{$document_number}} | {{$project->number}}
                                                            | {{$project->name}} </h4>
                                                    </div>
                                                    @if($errors->any())
                                                    <div class="alert alert-info">
                                                        <ul>
                                                            <li>{{$errors->first()}}</li>
                                                        </ul>
                                                    </div>
                                                    @endif
                                                    <div class="card-body">
                                                        <form id="project_document_save" method="post"
                                                            action="{{$update ? route('projects.document_update',$document->id) : route('projects.document_store')}}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="document_type" value="1" />
                                                            <input type="hidden" name="document_number"
                                                                value="{{$document_number}}" />

                                                            <input type="hidden" name="project_id"
                                                                value="{{$project->id}}" />
                                                            @foreach($headings as $index => $headings)

                                                            <div class="row" key="heading_{{$headings['id']}}">
                                                                <input id="heading_id"
                                                                    name="document[{{$index}}][heading_id]"
                                                                    type="hidden" value="{{$headings['id']}}" />
                                                                <div class="col-lg-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h4>{{$index+1}}.
                                                                                {{$headings['heading_title']}}
                                                                            </h4>
                                                                            @if($headings['id'] ==1 || $headings['id']
                                                                            ==2)
                                                                            <p></p>
                                                                            @endif
                                                                            <div class="card-header-action">
                                                                                @if($headings['id'] ==1 ||
                                                                                $headings['id'] ===2)
                                                                                @else
                                                                                <a data-collapse="#heading_{{$headings['id']}}mycard-collapse"
                                                                                    class="btn btn-icon btn-info"
                                                                                    href="#">
                                                                                    <i class="fas fa-plus"></i></a>
                                                                                @endif
                                                                                @if($headings['id'] ==8 ||
                                                                                $headings['id'] ==9 ||
                                                                                $headings['id']
                                                                                ==10 )
                                                                                <button type="button"
                                                                                    data-title="{{$headings['heading_title']}}"
                                                                                    data-content="{{getContentPop($index,$headings->heading_content,$headings['heading_title'],$headings['id'],$headings['heading_selected_content'])}}"
                                                                                    class="btn btn-icon btn-info btn_documents_add">
                                                                                    <i class="fas fa-eye"></i></button>
                                                                                @endif
                                                                            </div>


                                                                        </div>
                                                                        <div class="collapse {{$headings['id'] ==1 || $headings['id'] ==2 ? 'show':''}}"
                                                                            id="heading_{{$headings['id']}}mycard-collapse"
                                                                            style="">
                                                                            <div class="card-body">
                                                                                @if($headings['id'] ==1)
                                                                                <p>{{$client->client_name}}</p>
                                                                                @endif
                                                                                @if($headings['id'] ==2)
                                                                                <p>{{$project->project_address}}</p>
                                                                                @endif
                                                                                @if(
                                                                                $headings['id']
                                                                                ==4)
                                                                                <textarea
                                                                                    class="manualtext_common form-control mt-2"
                                                                                    name="document[{{$index}}][heading_summernote]">{{$headings['heading_selected_content']}}</textarea>
                                                                                @endif
                                                                                @if($headings['id'] ==8 ||
                                                                                $headings['id'] ==9 ||
                                                                                $headings['id']
                                                                                ==10 )
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <textarea
                                                                                            name="document[{{$index}}][heading_summernote]"
                                                                                            class="summernote heading_{{$headings['id']}}_summernote_final">{{$headings['heading_selected_content']}}</textarea>
                                                                                    </div>

                                                                                </div>
                                                                                @endif
                                                                                @if($headings['id'] ==3)
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">

                                                                                            <label><strong>a) Statische
                                                                                                    Berechnung</strong>
                                                                                            </label>
                                                                                            <textarea
                                                                                                class="manualtext_common form-control mt-2"
                                                                                                name="document[{{$index}}][heading_summernote][a]">{{$headings['heading_selected_sub_content']->a ?? ''}}</textarea>
                                                                                        </div>

                                                                                    </div>

                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">

                                                                                            <label><strong>b)
                                                                                                    Zeichnungen</strong></label>
                                                                                            <textarea
                                                                                                class="manualtext_common form-control mt-2"
                                                                                                name="document[{{$index}}][heading_summernote][b]">{{$headings['heading_selected_sub_content']->b ?? ''}}</textarea>
                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                                @endif
                                                                                @if($headings['id'] ==7)
                                                                                <p><strong>a) Beton</strong></p>
                                                                                <div class="row">

                                                                                    <div class="col-lg-4">
                                                                                        <label>Select
                                                                                            Options</label>
                                                                                    </div>
                                                                                    <div class="col-lg-5">
                                                                                        <select
                                                                                            name="document[{{$index}}][heading_summernote][a][]"
                                                                                            class="form-control select2 mt-2"
                                                                                            multiple="">
                                                                                            @foreach($heading_dropdown_common
                                                                                            as $heading_dropdown )
                                                                                            @if($heading_dropdown->type
                                                                                            == 7)
                                                                                            <option
                                                                                                value="{{$heading_dropdown->id}}"
                                                                                                {{in_array($heading_dropdown->
                                                                                                id,$headings['heading_selected_sub_content']->a
                                                                                                ?? [])
                                                                                                ?
                                                                                                'selected': ''}}>
                                                                                                {{$heading_dropdown->name}}
                                                                                            </option>
                                                                                            @endif
                                                                                            @endforeach
                                                                                        </select>

                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <input type="text"
                                                                                            style="border: solid 2px #9a9a9a;"
                                                                                            name="document[{{$index}}][heading_summernote][aa]"
                                                                                            class="form-control"
                                                                                            value="{{$headings['heading_selected_sub_content']->aa ?? ''}}" />
                                                                                    </div>
                                                                                </div>
                                                                                <p><strong>b)
                                                                                        Expositionsklasse</strong>
                                                                                </p>
                                                                                <div class="row">
                                                                                    <div class="col-lg-4">
                                                                                        <label>Select
                                                                                            Options</label>
                                                                                    </div>
                                                                                    <div class="col-lg-5">
                                                                                        <select
                                                                                            name="document[{{$index}}][heading_summernote][b][]"
                                                                                            class="form-control select2 mt-2"
                                                                                            multiple="">
                                                                                            @foreach($heading_dropdown_common
                                                                                            as $heading_dropdown )
                                                                                            @if($heading_dropdown->type
                                                                                            == 7)
                                                                                            <option
                                                                                                value="{{$heading_dropdown->id}}"
                                                                                                {{in_array($heading_dropdown->
                                                                                                id,$headings['heading_selected_sub_content']->b
                                                                                                ??[])
                                                                                                ?
                                                                                                'selected': ''}}>
                                                                                                {{$heading_dropdown->name}}
                                                                                            </option>
                                                                                            @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <input type="text"
                                                                                            style="border: solid 2px #9a9a9a;"
                                                                                            name="document[{{$index}}][heading_summernote][bb]"
                                                                                            class="form-control"
                                                                                            value="{{$headings['heading_selected_sub_content']->bb ?? ''}}" />
                                                                                    </div>

                                                                                </div>
                                                                                <p><strong>c) Baustahl</strong>
                                                                                </p>
                                                                                <div class="row">
                                                                                    <div class="col-lg-4">
                                                                                        <label>Select
                                                                                            Options</label>
                                                                                    </div>
                                                                                    <div class="col-lg-5">
                                                                                        <select
                                                                                            name="document[{{$index}}][heading_summernote][c][]"
                                                                                            class="form-control select2 mt-2"
                                                                                            multiple="">
                                                                                            @foreach($heading_dropdown_common
                                                                                            as $heading_dropdown )
                                                                                            @if($heading_dropdown->type
                                                                                            == 7)
                                                                                            <option
                                                                                                value="{{$heading_dropdown->id}}"
                                                                                                {{in_array($heading_dropdown->
                                                                                                id,$headings['heading_selected_sub_content']->c
                                                                                                ?? [])
                                                                                                ?
                                                                                                'selected': ''}}>
                                                                                                {{$heading_dropdown->name}}
                                                                                            </option>
                                                                                            @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <input type="text"
                                                                                            style="border: solid 2px #9a9a9a;"
                                                                                            name="document[{{$index}}][heading_summernote][cc]"
                                                                                            class="form-control"
                                                                                            value="{{$headings['heading_selected_sub_content']->cc ?? ''}}" />
                                                                                    </div>
                                                                                </div>
                                                                                <p><strong>d) Mauerwerk</strong>
                                                                                </p>

                                                                                <div class="row">
                                                                                    <div class="col-lg-4">
                                                                                        <label>Select
                                                                                            Options</label>
                                                                                    </div>
                                                                                    <div class="col-lg-5">
                                                                                        <select
                                                                                            name="document[{{$index}}][heading_summernote][d][]"
                                                                                            class="form-control select2 mt-2"
                                                                                            multiple="">
                                                                                            @foreach($heading_dropdown_common
                                                                                            as $heading_dropdown )
                                                                                            @if($heading_dropdown->type
                                                                                            == 7)
                                                                                            <option
                                                                                                value="{{$heading_dropdown->id}}"
                                                                                                {{in_array($heading_dropdown->
                                                                                                id,$headings['heading_selected_sub_content']->d
                                                                                                ?? [])
                                                                                                ?
                                                                                                'selected': ''}}>
                                                                                                {{$heading_dropdown->name}}
                                                                                            </option>
                                                                                            @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        <input type="text"
                                                                                            style="border: solid 2px #9a9a9a;"
                                                                                            name="document[{{$index}}][heading_summernote][dd]"
                                                                                            class="form-control"
                                                                                            value="{{$headings['heading_selected_sub_content']->dd ?? ''}}" />
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                                @if($headings['id'] ==5 ||
                                                                                $headings['id'] ==6)
                                                                                <div class="row">
                                                                                    <div class="col-lg-8">
                                                                                        <label>Select
                                                                                            Options</label>
                                                                                        <select
                                                                                            name="document[{{$index}}][heading_summernote][a][]"
                                                                                            class="form-control select2 mt-2"
                                                                                            multiple="">
                                                                                            @foreach($heading_dropdown_common
                                                                                            as $heading_dropdown )
                                                                                            @if($heading_dropdown->type
                                                                                            == $headings['id'])
                                                                                            <option
                                                                                                value="{{$heading_dropdown->id}}"
                                                                                                {{in_array($heading_dropdown->
                                                                                                id,$headings['heading_selected_sub_content']->a
                                                                                                ?? [])
                                                                                                ?
                                                                                                'selected': ''}}>
                                                                                                {{$heading_dropdown->name}}
                                                                                            </option>
                                                                                            @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-4">
                                                                                        <label>&nbsp;&nbsp;</label>
                                                                                        <input type="text"
                                                                                            style="border: solid 2px #9a9a9a;"
                                                                                            name="document[{{$index}}][heading_summernote][aa]"
                                                                                            class="form-control"
                                                                                            value="{{$headings['heading_selected_sub_content']->aa ?? ''}}" />
                                                                                    </div>
                                                                                </div>

                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            @endforeach
                                                            <input type="submit" id="btn_project_document_save"
                                                                value="Save Document" class="btn btn-primary" />
                                                            @if($update)
                                                            <a href="{{route('projects.prufing_pdf_export',$document->id)}}"
                                                                id="btn_export_pdf" class="btn btn-primary">Export
                                                                To
                                                                PDF</a>
                                                            @endif
                                                            <a href="{{route('projects.view',$project->id)}}"
                                                                id="btn_export_pdf" class="btn btn-danger">Back
                                                                To
                                                                Project</a>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
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
    <div class="modal modal_fullscreen" id="modal_fullscreen">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title"></h4>
                    <button type="button" class="close btn-close-modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="full-screen-modal-body">
                    Modal body..
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-close-modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @section("script")
    <script>

        $(document).on("click", ".btn-close-modal", function () {
            $("body").removeClass("disable-scroll")
            $("#full-screen-modal-body").html("");
            $("#modal_fullscreen").modal("hide");
        });
        $(document).on("click", ".btn_documents_add", function () {
            var content = $(this).data('content');
            var title = $(this).data('title');
            $("#modal_title").html(title);
            var html = content;
            $("#full-screen-modal-body").html(html);
            $('.summernote').summernote({
                height: '60vh',
                focus: true,
            });
            $("body").addClass("disable-scroll");

            $("#modal_fullscreen").modal("show");
        });
        $('.summernote').summernote();

        $(document).on("change", ".content_checkbox", function () {

            var ckeid = $(this).data('ckeid');
            $('.' + ckeid).summernote('focus'); 4
            var parent = "<div id='parent_ul' style='padding:0px;'></div>"
            var note = $('.' + ckeid).summernote('code');
            var isnoteEmpty = $('.' + ckeid).summernote('isEmpty');
            // alert(note);
            if (isnoteEmpty || note == "<br>" || note == "") {
                note = parent;
            }
            var tempElement = $('<div>').html(note);
            var subhead = $(this).data("subheading");
            var headingId = $(this).data("headingid");
            var targetElement = tempElement.find("#heading_" + headingId);
            var value = "<li style='list-style: none;'>" + $(this).val() + "</li>";
            if (targetElement.length > 0) {
                targetElement.append(value);
            } else {
                targetElement = tempElement.find("#parent_ul");
                var child = "<ul id='heading_" + headingId + "' style='padding:0px;margin-left:0px;'>" + subhead + value + "</ul>"
                targetElement.append(child);
            }


            // var isinclude = last_heading.includes(headingId);
            // console.log(headingId + "-->" + isinclude);
            // if (!last_heading.includes(headingId)) {
            //     last_heading.push(headingId);
            //       value = "<li>" + subhead + "</li>" + value;
            // }
            // $('.' + ckeid).summernote('code', tempElement.html());

            // note += "" + value;
            // // var tag = $(this).data('tag');
            if ($(this).prop('checked') === true) {
                $("." + ckeid).summernote("code", tempElement.html());
            }
        });
        $(document).on('click', '#btn-save-change', function () {
            var noteid = $(this).data("noteid");
            var final_note = $("#" + noteid + "pop").val();
            $("." + noteid + "_final").summernote("code", final_note);
            $("body").removeClass("disable-scroll")
            $("#full-screen-modal-body").html("");
            $("#modal_fullscreen").hide();
            $("#btn_project_document_save").trigger("click");
        });
        $('.search_inside_list').bind('keyup', function () {

            var searchString = $(this).val();
            var search_class = $(this).data('search')

            $("ul li").each(function (index, value) {

                currentName = $(value).text()
                if (currentName.toUpperCase().indexOf(searchString.toUpperCase()) > -1) {
                    $("." + search_class).mark();
                } else {
                    $("." + search_class).unmark();
                }

            });

        });
        $(document).on("keydown", "form", function (event) {
            return event.key != "Enter";
        });
        $(document).on("change", ".search_inside_list", function (event) {
            alert("hello");
        });
        $(document).on("click", ".content_mycard-collapse", function (event) {
            var target = $(this).data('collapse');

            var me = $(this);
            me.click(function () {
                $(target).collapse("toggle");
                $(target).on("shown.bs.collapse", function () {
                    me.html('<i class="fas fa-minus"></i>');
                });
                $(target).on("hidden.bs.collapse", function () {
                    me.html('<i class="fas fa-plus"></i>');
                });
                return false;
            });

            // if($(collapse).css('display')== "block"){
            // $(collapse).hide();
            // } else {
            // $(collapse).show();
        });

    </script>

    @stop
</x-app-layout>