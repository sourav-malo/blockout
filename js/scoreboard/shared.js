var set = $('#set');
var pit = $('#pit');
var level = $('#level');
var countries = $('#countries');
var cities = $('#cities');
var device = $('#device');
var totalScoresCountSpan = $('#total-scores-count');
var sbTbody = $('#sbTbody');
var paginationItems = $('#pagination-items');

var MAX_PAGES_COUNT_IN_PAGINATION = 10;
var MAX_PAGES_COUNT_ON_LEFT = (MAX_PAGES_COUNT_IN_PAGINATION / 2);
var MAX_PAGES_COUNT_ON_RIGHT = (MAX_PAGES_COUNT_IN_PAGINATION % 2) ? (MAX_PAGES_COUNT_IN_PAGINATION / 2) : (MAX_PAGES_COUNT_IN_PAGINATION / 2) - 1;