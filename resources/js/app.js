require('./bootstrap');

import 'jquery-ui/ui/widgets/datepicker.js';
import $ from 'jquery';
window.$ = window.jQuery = $;


$('.datepicker').datepicker();
