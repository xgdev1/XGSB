import './styles/xgsb_bo.scss';
import $ from 'jquery';
import 'bootstrap';
import { Tooltip } from 'bootstrap';


const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))
console.log('This log backoffice');
$(document).ready(function(){
    $('.btn-close-menu').on('click', function() {
        $('#sidebar').toggleClass('inactive');
        $('#content').toggleClass('active');
    });
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('inactive');
        $('#content').toggleClass('active');
    });
})