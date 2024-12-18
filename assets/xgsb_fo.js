import './styles/xgsb_fo.scss';
import $ from 'jquery';
import 'bootstrap';

console.log('This log frontoffice');

$(document).ready(function (){
    $("video").each(function() {
      $(this).get(0).play()
  });
})