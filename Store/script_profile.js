document.addEventListener("DOMContentLoaded", function () {
    const personalTab = document.getElementById("personalTab");
    const orderHistoryTab = document.getElementById("orderHistoryTab");
    const personalContent = document.getElementById("personalContent");
    const orderHistoryContent = document.getElementById("orderHistoryContent");
    personalTab.addEventListener("click", function () {
    personalContent.style.display = "block";
    orderHistoryContent.style.display = "none";
    });
    orderHistoryTab.addEventListener("click", function () {
    personalContent.style.display = "none";
    orderHistoryContent.style.display = "block";
    });
    personalTab.click();
   });
   