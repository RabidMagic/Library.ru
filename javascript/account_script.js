window.addEventListener("load", pageLoaded, false);

function getEl(id) {
    return document.getElementById(id);
}

function pageLoaded(){
    addEvents();
}

function addEvents() {
    if (getEl("coffee")  ){
        getEl("coffee").addEventListener("click", popUp, false);
        getEl("coffee").addEventListener("mouseenter", mesUp, false);
    }
    if (getEl("addbook")){
        getEl("addbook").addEventListener("click", popUp, false);
        getEl("addbook").addEventListener("mouseenter", mesUp, false);
    }         
}

function mesUp() {
    var choice = this.getAttribute("id");
    var mesText;
    var mes = document.createElement("p");
    mes.id = "mes" + choice;
    mes.className = "mes";
    switch (choice) {
        case "coffee": 
            mesText = "Админ-панель";
            break
        case "addbook":
            mesText = "Добавление книги";
            break
    }
    mes.innerHTML = mesText;
    getEl(choice).addEventListener("mouseout", mesDown, false);
    getEl(choice).addEventListener("mousemove", mesMove, false);
    document.body.appendChild(mes);
    var mouse_x = 0;
    var mouse_y = 0;
    if (document.attachEvent != null) {
        mouse_x = window.event.clientX;
        mouse_y = window.event.clientY;
    } else if (!document.attachEvent && document.addEventListener) {
        mouse_x = event.clientX;
        mouse_y = event.clientY;
    }
    mes.style.left = mouse_x + "px";
    mes.style.top = mouse_y + "px";
}

function mesDown() {
    var el = "mes" + this.getAttribute("id");
    el = getEl(el);
    el.parentNode.removeChild(el);
}

function mesMove() {
    var mes = getEl("mes" + this.getAttribute("id"));
    var mouse_x = 0;
    var mouse_y = 0;
    if (document.attachEvent != null) {
        mouse_x = window.event.clientX;
        mouse_y = window.event.clientY;
    } else if (!document.attachEvent && document.addEventListener) {
        mouse_x = event.clientX;
        mouse_y = event.clientY;
    }
    mes.style.left = mouse_x + "px";
    mes.style.top = mouse_y + "px";
}

function popUp() {
    var choice = this.getAttribute("id");
    switch (choice) {
        case "coffee":
            addAdmin();
            break
        case "addbook":
            addBook();
            break
    }
}

function addHeader() {
    var header = document.createElement("div");
    header.id = "popUp";
    header.innerHTML = "<div class='accountPopup'><div id='close'>X</div></div>";
    var container = getEl("container");
    document.body.insertBefore(header, container);
}

function addAdmin() {
    if (getEl("Admin")) {
        addHeader();
        var admin = getEl("Admin");
        var target = getEl("popUp").childNodes[0];
        target.appendChild(admin);
        getEl("close").addEventListener("click", popDown, false);
    }
}

function addBook() {
    if (getEl("Book")) {
        addHeader();
        var book = getEl("Book");
        var target = getEl("popUp").childNodes[0];
        target.appendChild(book);
        getEl("close").addEventListener("click", popDown, false);
    }
}

function popDown() {
    var el = getEl("popUp");
    var target = el.childNodes[0].childNodes[1];
    getEl("popup-info").appendChild(target);
    el.parentNode.removeChild(el);
}

