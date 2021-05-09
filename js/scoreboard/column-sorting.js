function makeColumnSortingDefault() {
  var sortIconContainers = $('.sort-icon-container');
  sortIconContainers.attr('data-sort-type', 'DEFAULT');

  var sortIconAscDescSpans = $('.sort-icon-asc, .sort-icon-desc');
  sortIconAscDescSpans.removeClass('active');
}

function makeColumnSortingAsc(sortIconContainerTargetted) {
  sortIconContainerTargetted.attr('data-sort-type', 'ASC');
  
  var sortIconAscSpan = sortIconContainerTargetted.find('.sort-icon-asc');
  sortIconAscSpan.addClass('active');
}

function makeColumnSortingDesc(sortIconContainerTargetted) {
  sortIconContainerTargetted.attr('data-sort-type', 'DESC');

  var sortIconDescSpan = sortIconContainerTargetted.find('.sort-icon-desc');
  sortIconDescSpan.addClass('active');
}

function handleColumnSorting(event) {
  var currentSortTypeOfColumn = $(event.target).hasClass('sort-icon-container') ? $(event.target).attr('data-sort-type') : $(event.target).closest('.sort-icon-container').attr('data-sort-type');

  if(currentSortTypeOfColumn != 'DEFAULT' && currentSortTypeOfColumn != 'DESC' && currentSortTypeOfColumn != 'ASC') return;

  makeColumnSortingDefault();

  var sortIconContainerTargetted = $(event.target).hasClass('sort-icon-container') ? $(event.target) : $(event.target).closest('.sort-icon-container');

  (currentSortTypeOfColumn == 'ASC') ? makeColumnSortingDesc(sortIconContainerTargetted) : makeColumnSortingAsc(sortIconContainerTargetted);

  // sort column
  getScores(1, sortIconContainerTargetted.attr('data-sort-col'), sortIconContainerTargetted.attr('data-sort-type'));
}