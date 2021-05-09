function renderTotalScoresCount(totalScoresCount) {
  totalScoresCountSpan.text(totalScoresCount);
}

function renderScores(scores, currentPageNo, maxRowsPerPage) {
  sbTbody.html('');

  $.each(scores, function(index, score) {
    sbTbody.append(`<div class="sb-row">
      <span class="sb-col rank">
        <span class="circle">${((currentPageNo - 1) * maxRowsPerPage) + index + 1}</span>
      </span>
      <span class="sb-col player">${score.playerName}</span>
      <span class="sb-col set">${score.gameSet}</span>
      <span class="sb-col pit">${score.gamePit}</span>
      <span class="sb-col level">${score.gameLevel}</span>
      <span class="sb-col score">${score.playerScore}</span>
      <span class="sb-col played-at">${score.playedAt}</span>
      <span class="sb-col country">${score.countryName}</span>
      <span class="sb-col ip-address">
        <form action="location.php" method="POST">
          <input type="hidden" name="ipAddress" value="${score.$ipAddress}">
          <button class="ip-address-btn">${score.cityName}</button>
        </form>
      </span>
      <span class="sb-col pc_phone">${score.PC_Phone}</span>
    </div>`);
  });
}

function renderPagination(leftmostPageNoInPagination, rightmostPageNoInPagination, currentPageNo, totalPages) {
  if(leftmostPageNoInPagination - 1 >= 1) {
    paginationItems.append(`
      <li onclick="getScores(${leftmostPageNoInPagination - 1}, 'playerScore', 'DESC')" class="pagination-item">
        <i class="fas fa-arrow-left"></i>
      </li>
    `);
  }

  for(var i = leftmostPageNoInPagination; i <= rightmostPageNoInPagination; i++) {
    paginationItems.append(`
      <li onclick="getScores(${i}, 'playerScore', 'DESC')" class="pagination-item ${currentPageNo == i ? "active": null}">
        ${i}
      </li>
    `);
  }

  if(rightmostPageNoInPagination + 1 <= totalPages) {
    paginationItems.append(`
      <li onclick="getScores(${rightmostPageNoInPagination + 1}, 'playerScore', 'DESC')" class="pagination-item">
        <i class="fas fa-arrow-right"></i>
      </li>
    `);
  }
}

function handlePagination(totalPages, currentPageNo) {
  var leftmostPageNoInPagination = 1;
  var rightmostPageNoInPagination = totalPages;

  if(currentPageNo - MAX_PAGES_COUNT_ON_LEFT >= 1 && currentPageNo + MAX_PAGES_COUNT_ON_RIGHT <= totalPages) {
    leftmostPageNoInPagination = currentPageNo - MAX_PAGES_COUNT_ON_LEFT;
    rightmostPageNoInPagination = currentPageNo + MAX_PAGES_COUNT_ON_RIGHT;
  } else if(currentPageNo - MAX_PAGES_COUNT_ON_LEFT >= 1) {
    leftmostPageNoInPagination = Math.max(1, totalPages - MAX_PAGES_COUNT_IN_PAGINATION - 1);
  } else if(currentPageNo + MAX_PAGES_COUNT_ON_RIGHT <= totalPages) {
    rightmostPageNoInPagination = Math.min(MAX_PAGES_COUNT_IN_PAGINATION, totalPages);
  }

  paginationItems.html('');
  renderPagination(leftmostPageNoInPagination, rightmostPageNoInPagination, currentPageNo, totalPages);
}

async function getScores(pageNoValue, selectedColumn, selectedColumnSortType) {
  var apiURL = 'api/read-page.php'; 

  var body = {
    setValue: set.val(),
    pitValue: pit.val(),
    levelValue: level.val(),
    countriesValue: countries.val(),
    citiesValue: cities.val(),
    deviceValue: device.val(),
    selectedColumn,
    selectedColumnSortType,
    pageNoValue
  };

  var res = await fetch(apiURL, {
    method: 'POST',
    headers: {
      'Content-type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify(body)
  });

  res = await res.json();

  if(res.status != 'success') {
    renderTotalScoresCount(0);
    sbTbody.html('');
    paginationItems.html('');
    return;
  }  

  renderTotalScoresCount(res.data.totalRows);
  renderScores(res.data.scoresInCurrentPage, res.data.currentPageNo, res.data.maxRowsPerPage);
  handlePagination(res.data.totalPages, res.data.currentPageNo);
}

function filterScores(event) {
  event.preventDefault();

  // filter rows
  getScores(1, 'playerScore', 'DESC');
}

// init call
getScores(1, 'playerScore', 'DESC');