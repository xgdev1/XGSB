import './styles/xgsb_fo.scss';
import $ from 'jquery';
import 'bootstrap';
import { Collapse } from 'bootstrap';

var mainMenu;
console.log('This log frontoffice');

$(document).ready(function (){
    mainMenu=new Collapse("#navbarEpro",{toggle:false});
    mainMenu.hide();
    $("#btnMenu").on("click",function(){
       mainMenu.toggle();
    });
    $("video").each(function() {
      $(this).get(0).play()
    });
})