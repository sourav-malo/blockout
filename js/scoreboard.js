const set = document.querySelector('#set');
const pit = document.querySelector('#pit');
const level = document.querySelector('#level');
const device = document.querySelector('#device');
const sbFiltersForm = document.querySelector('#sbFiltersForm');
const sbTbody = document.querySelector('#sbTbody');
const paginationForm = document.querySelector('#pagination-form');
const curPageCountSpan = document.querySelector('#cur-page-count');
const totalPageCountSpan = document.querySelector('#total-page-count');
const pageNoInp = document.querySelector('#page-no-inp');

function loadPageCount(setValue, pitValue, levelValue, deviceValue) {
  var xhttp = new XMLHttpRequest();
  xhttp.open("POST", "api/read-page-count.php", true);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.setRequestHeader('Accept', 'text/html');
  xhttp.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
      pageNoInp.value = "1";
      curPageCountSpan.innerText = "1";
      totalPageCountSpan.innerText = this.responseText;
    }
  };
  xhttp.send(`setValue=${setValue}&pitValue=${pitValue}&levelValue=${levelValue}&deviceValue=${deviceValue}`);
}

function loadScores(setValue, pitValue, levelValue, deviceValue, pageNoValue, needPageCount) {
  var xhttp = new XMLHttpRequest();
  xhttp.open("POST", "api/read-scores.php", true);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
      sbTbody.innerHTML = this.responseText;
      if(needPageCount) loadPageCount(setValue, pitValue, levelValue, deviceValue);
    }
  };
  xhttp.send(`setValue=${setValue}&pitValue=${pitValue}&levelValue=${levelValue}&deviceValue=${deviceValue}&pageNoValue=${pageNoValue}`);
}

sbFiltersForm.addEventListener('submit', e => {
  e.preventDefault();
  loadScores(set.value, pit.value, level.value, device.value, 1, true);
  pageNoInp.value = "1";
});

paginationForm.addEventListener('submit', e => {
  e.preventDefault();

  const pageNo = parseInt(pageNoInp.value);
  const totalPageCount = parseInt(totalPageCountSpan.innerText);

  if(!isNaN(pageNo) && pageNo > 0 && pageNo <= totalPageCount) {
    curPageCountSpan.innerText = pageNo;
    loadScores(set.value, pit.value, level.value, device.value, pageNo, false);
  } else {
    pageNoInp.value = "";
  }
})

loadScores(set.value, pit.value, level.value, device.value, 1, true);