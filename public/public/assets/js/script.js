function openTab(event, tabId) {
  // Get all tab content elements
  var tabContents = document.getElementsByClassName("tab-content");
  for (var i = 0; i < tabContents.length; i++) {
    tabContents[i].style.display = "none";
  }

  // Get all tab buttons
  var tabButtons = document.getElementsByClassName("tab-button");
  for (var i = 0; i < tabButtons.length; i++) {
    tabButtons[i].className = tabButtons[i].className.replace(" active", "");
  }

  // Show the current tab
  document.getElementById(tabId).style.display = "block";
  event.currentTarget.className += " active";
}

// Default open the first tab
document.querySelector(".tab-button.active").click();
