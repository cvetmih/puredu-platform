// require('./bootstrap');
//
// require('alpinejs');

// Notifications
const handleNotify = () => {

}

window.addEventListener('load', handleNotify);

const tabItems = document.querySelectorAll('[data-tabs]');

const handleTabsNavClick = (e) => {
    e.preventDefault();

    const targetTab = e.target.getAttribute('data-tabs-nav');
    const parent = e.target.closest('[data-tabs]');

    parent.querySelectorAll('[data-tab]').forEach((tab) => {
        if (tab.getAttribute('data-tab') === targetTab) {
            tab.classList.add('active');
        } else {
            tab.classList.remove('active');
        }
    });

    const navButtons = parent.querySelectorAll('[data-tabs-nav]').forEach((navButton) => {
        if (navButton.getAttribute('data-tabs-nav') === targetTab) {
            navButton.classList.add('bg-gradient-to-br', 'from-pink-400', 'to-purple-500');
            navButton.classList.remove('bg-white', 'bg-opacity-10', 'hover:bg-opacity-20');
        } else {
            navButton.classList.add('bg-white', 'bg-opacity-10', 'hover:bg-opacity-20');
            navButton.classList.remove('bg-gradient-to-br', 'from-pink-400', 'to-purple-500');
        }
    });
};

tabItems.forEach((item) => {
    const nav = item.querySelectorAll('[data-tabs-nav]');
    nav.forEach((navItem) => {
        navItem.addEventListener('click', handleTabsNavClick);
    })
})
