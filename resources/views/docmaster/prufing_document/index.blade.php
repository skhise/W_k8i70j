<?php
function getContent($index_main,$contents,$heading_title,$headings_id,$heading_selected_content){
   $li = "";
    $ckeid = "heading_".$headings_id."_summernote";
    $token = '<input type="hidden" name="_token" value="'.csrf_token().'" />';
    
    foreach($contents as $key => $content){
        $sub_ul="";
        $content_update_url = route("prufing_sub_heading.update",$content->id);
        $sub_heading_content_url = route("content_sub_content.add",$content->id); 
        if(isset($content->sub_content)){
            $sub_li = "";
            foreach($content->sub_content as $index => $subcontent) {
                $new_index = $index+1;
                $sub_content_url = route('content_sub_content.update',$subcontent->id);
                
                $sub_content_titless  = str_replace(' ','',$heading_title)."_sub_".$subcontent->id;
                $sub_li .= '<li class="li-bottom-border" style="list-style-type:none;" style="margin: 10px;" class="heading_{{$headings_id}}_search">
        <label style="display:flex;margin:0px;" for="'.$sub_content_titless.'">'.$token. $new_index.') <form style="width:100%;margin:0px;" method="post" action='.$sub_content_url.'><textarea name="content_details" id="sub_content_title_'.$subcontent->id.'" class="hide_border_textarea" style="float: left; width: 85%;height: 50px;" rows="1">'.preg_replace('/\n+/', ' ', $subcontent->content_details).'</textarea><div style="float:right;"><a data-subcontent_id="'.$subcontent->id.'" class="btn btn-icon btn-sub-content-edit"><i class="fas fa-edit"></i></a><button style="display:none;"
        class="btn btn-icon btn-primary btn-sub-content-save"
        data-sub_content_id="'.$subcontent->id.'"
        id="btn_sub_content_'.$subcontent->id.'_save"
        type="submit"><i
            class="fas fa-save"></i></button>

    <button type="button"
        style="display:none;"
        data-sub_content_id="'.$subcontent->id.'"
        class="btn btn-icon btn-danger btn-sub-content-save-cancel"
        id="btn_sub_content_'.$subcontent->id.'_cancel"><i
            class="fas fa-times"></i></button></div></form></label></li></hr>';
            }
            $sub_ul ="<ul class='collapse' style='padding-left:0px;' id='heading_".$content->id."_content_mycard-collapse'><li style='list-style-type:none;'><div style='display:flex;'><form style='width:100%;padding:10px;' method='post' action='".$sub_heading_content_url."'>".$token."<input style='float: left;width: 85%;' type='text' name='content_details'/>
           <div style='float:right;'> <button
            class='btn btn-icon btn-primary btn-add-heading-save'
            type='submit'><i
                class='fas fa-save'></i></button>
        <button 
            type='reset'
            class='btn btn-icon btn-danger btn-add-heading-save-cancel'><i
                class='fas fa-times'></i></button></div></form></div>".$sub_li."</ul>";
        }
        $sub_content_title  = str_replace(' ','',$heading_title)."_".$key;

        $li .= '<li style="list-style-type:none;" class="heading_{{$headings_id}}_search">
        <div class="row" style="background: #edefef;margin-top: 5px;margin-right: 10px;"><form style="width:100%;margin:0px;padding:10px;" method="post" action="'.$content_update_url.'"
        action="{{route(prufing_document.update,$content->id)}}">'.$token.'
        <span style="float: left;width: 85%" for="'.$sub_content_title.'"><input name="content_details" id="sub_heading_title_'.$content->id.'" class="hide_border1" style="width: 100%;" value="'.$content->content_details.'" /></span>
        <div style="float:right"><a data-collapse="#heading_'.$content->id.'_content_mycard-collapse" class="btn btn-icon content_mycard-collapse" href="#"><i class="fas fa-plus"></i></a>
        <a data-sub_heading_id="'.$content->id.'" class="btn btn-icon btn-sub-heading-edit"><i data-sub_heading_id="'.$content->id.'" class="fas fa-edit"></i></a>
        <button style="display:none;"
                                                                                        class="btn btn-icon btn-primary btn-sub-heading-save"
                                                                                        data-sub_heading_id="'.$content->id.'"
                                                                                        id="btn_sub_heading_'.$content->id.'_save"
                                                                                        type="submit"><i
                                                                                            class="fas fa-save"></i></button>

                                                                                    <button type="button"
                                                                                        style="display:none;"
                                                                                        data-sub_heading_id="'.$content->id.'"
                                                                                        class="btn btn-icon btn-danger btn-sub-heading-save-cancel"
                                                                                        id="btn_sub_heading_'.$content->id.'_cancel"><i
                                                                                            class="fas fa-times"></i></button></div>
                                                                                            </form></div></li>'.$sub_ul;
    }
    if($headings_id == 8 || $headings_id == 9 || $headings_id == 10){
     $sub_heading_url = route("prufing_sub_heading.add",$headings_id);   
    $ul ="<ul style='width: 100%;'><li style='list-style-type:none;'><div style='display: flex;'><form style='width:100%;padding:10px;' method='post' action='".$sub_heading_url."'>".$token."<input style='float:left;width:85%' type='text' name='content_details'/>
    <div style='float:right;'><button
    class='btn btn-icon btn-primary btn-add-heading-save'
    type='submit'><i
        class='fas fa-save'></i></button>
<button 
    type='reset'
    class='btn btn-icon btn-danger btn-add-heading-save-cancel'><i
        class='fas fa-times'></i></button></div></form></div></li>".$li."</ul>";
        return $ul;
    } else {
        $ul ="<ul style='width: 100%;'>".$li."</ul>";
        return $ul;
    }
    
}
?>
<style>
    .li-bottom-border {
        border-bottom: 1px solid #989898;
        padding: 10px;
    }

    .card .card-body {
        padding-top: 10px !important;
        padding-bottom: 15px !important;
    }

    .hide_border {
        border: 0px;
        pointer-events: none;
    }

    .hide_border1 {
        border: 0px;
        pointer-events: none;
        background: transparent;
    }

    .hide_border_textarea {
        border: 0px;
        pointer-events: none;
        background: transparent;
    }

    .hide_content {
        display: none;
    }

    .heading_title {
        width: 65%;
    }

    bottom:hover {
        cursor: pointer;
    }

    a:hover {
        cursor: pointer;
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
                                <h4>Prufing Documents</h4>
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
                                                    @if($errors->any())
                                                    <div class="alert alert-info">
                                                        <ul>
                                                            <li>{{$errors->first()}}</li>
                                                        </ul>
                                                    </div>
                                                    @endif
                                                    <div class="card-body">


                                                        <input type="hidden" name="document_type" value="1" />
                                                        @foreach($headings as $index => $headings)

                                                        <div class="row" key="heading_{{$headings['id']}}">
                                                            <input id="heading_id"
                                                                name="document[{{$index}}][heading_id]" type="hidden"
                                                                value="{{$headings['id']}}" />
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <form style="width:100%;" method="post"
                                                                            action="{{route('prufing_document.update',$headings['id'])}}">
                                                                            @csrf
                                                                            <div style="display:flex;">
                                                                                <h4 style="width:75%;">{{$index+1}}.
                                                                                    <input type="text"
                                                                                        class="hide_content heading_code"
                                                                                        name="heading_code"
                                                                                        id="heading_code_{{$headings['id']}}"
                                                                                        value="{{$headings['heading_code']}}" />
                                                                                    <input type="text"
                                                                                        class="hide_border heading_title"
                                                                                        value="{{$headings['heading_title']}}"
                                                                                        id="heading_title_{{$headings['id']}}"
                                                                                        name="heading_title" />
                                                                                </h4>

                                                                                <div class="card-header-action">
                                                                                    @if($headings['id'] ==1 ||
                                                                                    $headings['id'] ===2)
                                                                                    <a data-heading_id="{{$headings['id']}}"
                                                                                        class="btn btn-icon btn-info btn-heading-edit">
                                                                                        <i class="fas fa-edit"></i></a>

                                                                                    <button style="display:none;"
                                                                                        class="btn btn-icon btn-primary btn-save"
                                                                                        id="btn_{{$headings['id']}}_save"
                                                                                        type="submit"><i
                                                                                            class="fas fa-save"></i></button>

                                                                                    <button type="button"
                                                                                        style="display:none;"
                                                                                        class="btn btn-icon btn-danger btn_save_cancel"
                                                                                        id="btn_{{$headings['id']}}_cancel"><i
                                                                                            class="fas fa-times"></i></button>

                                                                                    @else
                                                                                    <a data-collapse="#heading_{{$headings['id']}}mycard-collapse"
                                                                                        class="btn btn-icon btn-info">
                                                                                        <i class="fas fa-plus"></i></a>
                                                                                    <a data-heading_id="{{$headings['id']}}"
                                                                                        class="btn btn-icon btn-info  btn-heading-edit">
                                                                                        <i class="fas fa-edit"></i></a>

                                                                                    <button style="display:none;"
                                                                                        class="btn btn-icon btn-primary btn-save"
                                                                                        id="btn_{{$headings['id']}}_save"
                                                                                        type="submit"><i
                                                                                            class="fas fa-save"></i></button>
                                                                                    <button type="button"
                                                                                        style="display:none;"
                                                                                        class="btn btn-icon btn-sm btn-danger btn_save_cancel"
                                                                                        id="btn_{{$headings['id']}}_cancel"><i
                                                                                            class="fas fa-times"></i></button>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="collapse {{$headings['id'] ==1 || $headings['id'] ==2 ? 'show':''}}"
                                                                        id="heading_{{$headings['id']}}mycard-collapse"
                                                                        style="">
                                                                        <div class="card-body">
                                                                            {!!
                                                                            getContent($index,$headings->heading_content,$headings['heading_title'],$headings['id'],$headings['heading_selected_content'])
                                                                            !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        @endforeach
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
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title"></h4>
                    <button type="button" class="close btn-close-modal" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="full-screen-modal-body">
                    Modal body..
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-close-modal" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    @section("script")
    <script>
        $(document).on("click", ".btn-sub-content-edit", function () {
            var id = $(this).data("subcontent_id");
            $(".btn-sub-content-save").hide()
            $(".btn-sub-content-edit").hide();
            $("#sub_content_title_" + id).removeClass("hide_border_textarea");
            $("#btn_sub_content_" + id + "_save").show();
            $("#btn_sub_content_" + id + "_cancel").show();
            $(this).css("display", "none");
        });
        $(document).on("click", ".btn-sub-content-save-cancel", function () {
            var id = $(this).data("sub_content_id");
            $(".btn-save").hide()
            $(".btn-sub-content-edit").show();
            $("#sub_content_title_" + id).addClass("hide_border_textarea");
            $("#btn_sub_content_" + id + "_save").hide();
            $("#btn_sub_content_" + id + "_cancel").hide();
            $(this).css("display", "none");
        });

        $(document).on("click", ".btn-sub-heading-edit", function () {
            var id = $(this).data("sub_heading_id");
            $(".btn-sub-heading-save").hide()
            $(".btn-sub-heading-edit").hide();
            $("#sub_heading_title_" + id).removeClass("hide_border1");
            $("#btn_sub_heading_" + id + "_save").show();
            $("#btn_sub_heading_" + id + "_cancel").show();
            $(this).css("display", "none");
        });
        $(document).on("click", ".btn-sub-heading-save-cancel", function () {
            var id = $(this).data("sub_heading_id");
            $(".btn-save").hide()
            $(".btn-sub-heading-edit").show();
            $("#sub_heading_title_" + id).addClass("hide_border1");
            $("#btn_sub_heading_" + id + "_save").hide();
            $("#btn_sub_heading_" + id + "_cancel").hide();
            $(this).css("display", "none");
        });
        $(document).on("click", ".btn_save_cancel", function () {
            var id = $(this).data("heading_id");
            $(".btn-save").hide()
            $(".btn-heading-edit").show();
            $(".heading_title").addClass("hide_border");
            $(".heading_code").addClass("hide_content");
            $("#btn_" + id + "_save").hide();
            $("#btn_" + id + "_cancel").hide();
            $(this).css("display", "none");
        });
        $(document).on("click", ".btn-heading-edit", function () {
            var id = $(this).data("heading_id");
            $(".btn-save").hide()
            $(".btn-heading-edit").hide();
            $("#heading_title_" + id).removeClass("hide_border");
            $("#heading_code_" + id).removeClass("hide_content");
            $("#btn_" + id + "_save").show();
            $("#btn_" + id + "_cancel").show();
            $(this).css("display", "none");
        });
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
            $('.' + ckeid).summernote('focus');
            var note = $('.' + ckeid).summernote('code');
            $('.' + ckeid).summernote('code');
            var value = $(this).val();
            note += "<br />" + value;
            var tag = $(this).data('tag');
            if ($(this).prop('checked') === true) {
                $("." + ckeid).summernote("code", note);
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
        });
        // if($(collapse).css('display')== "block"){
        // $(collapse).hide();
        // } else {
        // lla      // }

    </script>

    @stop
</x-app-layout>