const getToday = () => {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = ("0"+(today.getMonth()+1)).slice(-2);
    const dd = ("0"+today.getDate()).slice(-2);
    return yyyy+'-'+mm+'-'+dd;
}

export { getToday }

const getThisYear = () => {
    const today = new Date();
    const yyyy = today.getFullYear();
    return yyyy;
}

export { getThisYear }

const getThisMonth = () => {
    const today = new Date();
    const mm = today.getMonth() + 1;
    return mm;
}

export { getThisMonth }

const nl2br = (str) => {
    var res = str.replace(/\r\n/g, "<br>");
    res = res.replace(/(\n|\r)/g, "<br>");
    return res;
}

export { nl2br }

const active_btn = (els, currentRoute) => {
    if(route().current(currentRoute)) {
        els.forEach(el => {
            el.classList.add('nav_btn', 'active');
        });
    }
}

export { active_btn }
