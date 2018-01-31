const accordions = document.getElementsByClassName('has-submenu');
const leftSlideButton = document.getElementById('left-slideout-button');
const rightSlideButton = document.getElementById('right-slideout-button');
const leftSideMenu = document.getElementById('left-side-menu');
const rightSideMenu = document.getElementById('right-side-menu');

function setSubmenuStyles(submenu, maxHeight, margins) {
    submenu.style.maxHeight = maxHeight
    submenu.style.marginTop = margins
    submenu.style.marginBottom = margins
}
if (leftSlideButton && leftSideMenu) {
    leftSlideButton.onclick = function () {
        this.classList.toggle('is-active');
        document.getElementById('left-side-menu').classList.toggle('is-active');
    }
}

if (rightSlideButton && rightSideMenu) {
    rightSlideButton.onclick = function () {
        this.classList.toggle('is-active');
        document.getElementById('right-side-menu').classList.toggle('is-active');
    }
}


for (var i = 0; i < accordions.length; i++) {
    if (accordions[i].classList.contains('is-active')) {
        const submenu = accordions[i].nextElementSibling
        setSubmenuStyles(submenu, submenu.scrollHeight + "px", "0.75em")
    }

    accordions[i].onclick = function () {
        this.classList.toggle('m-t-5')
        this.classList.toggle('is-active')

        const submenu = this.nextElementSibling
        if (submenu.style.maxHeight) {
            // menu is open, we need to close it now
            setSubmenuStyles(submenu, null, null)
        } else {
            // meny is close, so we need to open it
            setSubmenuStyles(submenu, submenu.scrollHeight + "px", "0.75em")
        }
    }
}
