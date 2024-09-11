import './styles/xgsb_bo.scss';
import $ from 'jquery';
import 'bootstrap';
import { Tooltip, Modal } from 'bootstrap';
var imgModal;
var formModal;
let activeIid;
let CIModalU;
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl));
console.log('This log backoffice');

function activateMedia(){
    if (typeof imgModal !== Modal){
        imgModal=new Modal('#imgModal');
        formModal=new Modal("#formModal");
    }
    $('.filecard').on('click', function(){
        console.log("clique sur fiche fichier");
        var fichier=$(this).data('file');
        console.log(fichier);
        var html="<img src='/"+fichier+"' class='img-fluid' />";
        $("#btnSelect").data('file', '/'+fichier);
        $("#btnRemove").data('file', fichier);
        $("#img-zoom").html(html);
        imgModal.show();
        var data = { 'file': fichier}
        $("#btnRemove").on("click", function(){
            $.ajax({
                url: "/BO/media/delete-file",
                data: data,
                complete: function(){
                    var current=$(".createDir").data('current');
                    imgModal.hide();
                    $("#contentDir").load("/BO/media/filelist?dir="+current, function(){
                        activateMedia();
                    });
                }
            })
        });
        $("#btnSelect").on("click", function(){
            console.log(activeIid);
            $("#"+activeIid).val("/"+fichier);
            imgModal.hide();
            if(CIModalU){
                CIModalU.hide();
            }
        })
    })
    $(".deleteDir").on('click', function(){
        var current=$(this).data('current');
        window.location.replace("/BO/media/delete-dir?dir="+current);
    });
    $(".createDir").on('click', function(){
       let newDir= prompt("Nom du nouveau repertoire ?");
       var current=$(this).data('current');
        window.location.replace("/BO/media/create-dir?dir="+current+"&newDir="+newDir);
    });
    $(".addFile").on('click', function(){
        var current=$(this).data('current');
        $("#upload_file_path").val(current);
        formModal.show();
        $('form[name="upload_file"]').submit(function(e){
            e.preventDefault();
            var formData= new FormData();
            formData.append("upload_file[path]", $("#upload_file_path").val() );
            formData.append("upload_file[file]", $("#upload_file_file")[0].files[0] );
            console.log(formData);
            $.ajax({
                url: '/BO/media/upload-file',
                type: 'POST',
                data: formData,
                success: function(data){
                    formModal.hide();
                    $("#contentDir").load("/BO/media/filelist?dir="+current, function(){
                        $("#upload_file_file").val("");
                        activateMedia();
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            })
        });
        /**var fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = 'image/*';
        fileInput.onchange = function(event) {
            var file = event.target.files[0];
            var formData = new FormData();
            formData.append('file', file);
            $.ajax({
                url: '/BO/media/add-file',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        };**/
    });
}

$(document).ready(function(){
    $('.btn-close-menu').on('click', function() {
        $('#sidebar').toggleClass('inactive');
        $('#content').toggleClass('active');
    });
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('inactive');
        $('#content').toggleClass('active');
    });
    $('.dirBtn').on("click", function(){
        console.log("Debut du traitement");
        var current=$(this).data("current")
        console.log(current);
        var collapse=$(this).data("collapse");
        console.log(collapse);
        if (typeof collapse!=='undefined'){
            $("#"+collapse).addClass('show');
        }
        $("#contentDir").load("/BO/media/filelist?dir="+current, function(){
            activateMedia();
        });
    })
    if(document.getElementById('imgModal')){
        activateMedia();
    }
    if(document.getElementsByClassName(".btn-choose-media")){
        $(".btn-choose-media").on("click", function(){
            var iid=$(this).data("iid") ;
            activeIid=iid;
            console.log(activeIid);
            var active=$("#"+iid).data("active");
            console.log("active="+active);
            var AjaxQ="?iid="+iid;
            if(active!== undefined){
                AjaxQ=AjaxQ+"&active="+active;
            }
            $("#btnSelect").data("iid", iid);
            $("#CIModal_"+iid+ " .modal-content").load("/BO/media/ajax"+AjaxQ, function(){
                let CIModalU= new Modal("#CIModal_"+iid);
                CIModalU.show();
                $('.dirBtn').on("click", function(){
                    console.log("Debut du traitement");
                    var current=$(this).data("current")
                    console.log(current);
                    var collapse=$(this).data("collapse");
                    console.log(collapse);
                    if (typeof collapse!=='undefined'){
                        $("#"+collapse).addClass('show');
                    }
                    $("#contentDir").load("/BO/media/filelist?dir="+current, function(){
                        activateMedia();
                    });
                })
                activateMedia();
            });
        });
        $(".btn-clear-media").on("click", function(){
            var iid=$(this).data("iid") ;
            $("#"+iid).val("");
        });
    }
})