window.addEventListener('load', function() {
    const buttons = document.querySelectorAll('.accordion_button');

    buttons.forEach((button) => {
    button.addEventListener('click', (e) => {
        const body = e.currentTarget.nextElementSibling;
        const thead = body.children[0];
        const theadHeight = thead.offsetHeight;
        const menu = e.currentTarget.parentNode;
        menu.classList.toggle('open');

        //条件分岐で開閉を切り替える
        if(menu.classList.contains('open')) {
        body.style.height = theadHeight + 'px';
        } else {
        body.style.height = 0;
        }
    });
    });

});
