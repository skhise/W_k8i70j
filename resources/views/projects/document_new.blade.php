<?php
function getContent($contents,$heading_title,$headings_id){
   $li = "";
    $ckeid = "heading_".$headings_id."_summernote";
    foreach($contents as $key => $content){
        $sub_ul="";
        if(isset($content->sub_content)){
            $sub_li = "";
            foreach($content->sub_content as $index => $subcontent) {
                $sub_content_titless  = str_replace(' ','',$heading_title)."_sub_".$subcontent->id;
                $sub_li .= '<li  style="list-style-type:none;" class="heading_{{headings_id}}_search"><div class="custom-checkbox custom-control">
        <input type="checkbox" data-tag="child"  data-ckeid="'.$ckeid.'" data-checkboxes="mygroup" class="content_checkbox custom-control-input"
          id="'.$sub_content_titless.'" value="'.$subcontent->content_details.'">
        <label for="'.$sub_content_titless.'" class="custom-control-label">&nbsp;'.$subcontent->content_details.'</label>&nbsp;&nbsp;'.$subcontent->option.' 
      </div></li>';
            }
            $sub_ul ="<ul class='collapse' style='padding-left:0px;' id='heading_".$content->id."_content_mycard-collapse'>".$sub_li."</ul>";
        }
        $sub_content_title  = str_replace(' ','',$heading_title)."_".$key;

        $li .= '<li style="list-style-type:none;" class="heading_{{headings_id}}_search">
        <div class="row" style="background: #edefef;margin-top: 5px;margin-right: 10px;">
        <span style="flex: auto;" for="'.$sub_content_title.'">&nbsp;<strong>'.$content->content_details.'</strong></span>
        <a data-collapse="#heading_'.$content->id.'_content_mycard-collapse" class="btn btn-icon" href="#"><i class="fas fa-plus"></i></a>
      </div></li>'.$sub_ul;
    }
    $ul = "<ul style='width: 100%;'>".$li."</ul>";
    return $ul;
}
?>
<style>
    .card .card-body {
        padding-top: 10px !important;
        padding-bottom: 15px !important;
    }
</style>
<section class="section">
    <div class="row">

        <div class="col-md-12">
            <form id="project_document_save" method="post" action="{{route('projects.document_store')}}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="document_type" value="1" />
                <input type="hidden" name="document_number" value="{{$document_number}}" />

                <input type="hidden" name="project_id" value="{{$project->id}}" />
                @foreach($headings as $index => $headings)

                <div class="row" key="heading_{{$headings['id']}}">
                    <input id="heading_id" name="document[{{$index}}][heading_id]" type="hidden"
                        value="{{$headings['id']}}" />
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{$index+1}}.
                                    {{$headings['heading_title']}}
                                </h4>
                                @if($headings['id'] ==1 || $headings['id']
                                ==2)
                                <p></p>
                                @else
                                <div class="card-header-action">
                                    <a data-collapse="#heading_{{$headings['id']}}mycard-collapse"
                                        class="btn btn-icon btn-info" href="#">
                                        <i class="fas fa-plus"></i></a>
                                </div>
                                @endif

                            </div>
                            <div class="collapse {{$headings['id'] ==1 || $headings['id'] ==2 ? 'show':''}}"
                                id="heading_{{$headings['id']}}mycard-collapse" style="">
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
                                    <textarea class="manualtext_common form-control mt-2"
                                        name="document[{{$index}}][heading_summernote]"></textarea>
                                    @endif
                                    @if($headings['id'] ==8 ||
                                    $headings['id'] ==9 ||
                                    $headings['id']
                                    ==10 )
                                    <input type="text" name="search" class="form-control search_inside_list mr-2"
                                        data-search="heading_{{$headings['id']}}_search" placeholder="Search">
                                    <div class="row content_scroll">
                                        {!!
                                        getContent($headings->heading_content,$headings['heading_title'],$headings['id'])
                                        !!}
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <textarea name="document[{{$index}}][heading_summernote]" class="summernote"
                                                id="heading_{{$headings['id']}}_summernote">{{$headings['heading_selected_content']}}</textarea>
                                        </div>

                                    </div>
                                    @endif
                                    @if($headings['id'] ==3)
                                    <div class="row">
                                        <label><strong>a) Statische
                                                Berechnung</strong>
                                        </label>
                                        <textarea class="manualtext_common form-control mt-2"
                                            name="document[{{$index}}][heading_summernote][a]"></textarea>
                                    </div>
                                    <div class="row">
                                        <label><strong>b)
                                                Zeichnungen</strong></label>
                                        <textarea class="manualtext_common form-control mt-2"
                                            name="document[{{$index}}][heading_summernote][b]"></textarea>
                                    </div>

                                    @endif
                                    @if($headings['id'] ==7)
                                    <p><strong>a) Beton</strong></p>
                                    <div class="row">

                                        <div class="col-lg-4">
                                            <label>Select
                                                Options</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <select name="document[{{$index}}][heading_summernote][a][]"
                                                class="form-control select2 mt-2" multiple="">
                                                @foreach($heading_dropdown_common
                                                as $heading_dropdown )
                                                @if($heading_dropdown->type
                                                == 7)
                                                <option value="{{$heading_dropdown->id}}">
                                                    {{$heading_dropdown->name}}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
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
                                        <div class="col-lg-8">
                                            <select name="document[{{$index}}][heading_summernote][b][]"
                                                class="form-control select2 mt-2" multiple="">
                                                @foreach($heading_dropdown_common
                                                as $heading_dropdown )
                                                @if($heading_dropdown->type
                                                == 7)
                                                <option value="{{$heading_dropdown->id}}">
                                                    {{$heading_dropdown->name}}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>
                                    <p><strong>c) Baustahl</strong>
                                    </p>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label>Select
                                                Options</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <select name="document[{{$index}}][heading_summernote][c][]"
                                                class="form-control select2 mt-2" multiple="">
                                                @foreach($heading_dropdown_common
                                                as $heading_dropdown )
                                                @if($heading_dropdown->type
                                                == 7)
                                                <option value="{{$heading_dropdown->id}}">
                                                    {{$heading_dropdown->name}}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <p><strong>d) Mauerwerk</strong>
                                    </p>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label>Select
                                                Options</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <select name="document[{{$index}}][heading_summernote][d][]"
                                                class="form-control select2 mt-2" multiple="">
                                                @foreach($heading_dropdown_common
                                                as $heading_dropdown )
                                                @if($heading_dropdown->type
                                                == 7)
                                                <option value="{{$heading_dropdown->id}}">
                                                    {{$heading_dropdown->name}}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    @if($headings['id'] ==5 ||
                                    $headings['id'] ==6)
                                    <div class="row">
                                        <label>Select
                                            Options</label>
                                        <select name="document[{{$index}}][heading_summernote][a][]"
                                            class="form-control select2 mt-2" multiple="">
                                            @foreach($heading_dropdown_common
                                            as $heading_dropdown )
                                            @if($heading_dropdown->type
                                            == $headings['id'])
                                            <option value="{{$heading_dropdown->id}}">
                                                {{$heading_dropdown->name}}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
                <input type="submit" id="btn_project_document_save" value="Save Project Document"
                    class="btn btn-primary" />
                <a href="{{route('projects.prufing_pdf_export',$project->id)}}" id="btn_export_pdf"
                    class="btn btn-primary">Export
                    To
                    PDF</a>

            </form>
        </div>
        <div class="col-md-6">

        </div>
    </div>
</section>
<!-- <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script> -->
<!-- Page Specific JS File -->


<script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote({
            enterHtml: ''
        });

        $(document).on("change", ".content_checkbox", function () {

            var ckeid = $(this).data('ckeid');
            $('#' + ckeid).summernote('focus');
            var note = $('#' + ckeid).summernote('code');
            $('#' + ckeid).summernote('code');
            var value = $(this).val();
            note += "<br/>" + value;
            var tag = $(this).data('tag');
            if ($(this).prop('checked') === true) {
                $("#" + ckeid).summernote("code", note);
            }
        });
        // $("#btn_project_document_save").on('click', function() {
        //     var form_data = $("#project_document_save").serialize();
        //     console.log(form_data);
        // });
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
    });
</script>