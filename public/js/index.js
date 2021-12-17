/**
    * @description      : 
    * @author           : christian
    * @group            : 
    * @created          : 27/08/2021 - 18:14:54
    * 
    * MODIFICATION LOG
    * - Version         : 1.0.0
    * - Date            : 27/08/2021
    * - Author          : christian
    * - Modification    : 
**/
const headerMobileButton = document.querySelector('.header-mobile-icon');
const headerMobileList = document.querySelector('.header-mobile-list');

headerMobileButton.addEventListener("click", () => {
    headerMobileList.classList.toggle('show');
});