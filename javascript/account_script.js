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
    }
    if (getEl("addbook")){
        getEl("addbook").addEventListener("click", popUp, false);
    }         
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
    addHeader();
    var admin = getEl("Admin");
    var target = getEl("popUp").childNodes[0];
    target.appendChild(admin);
    getEl("close").addEventListener("click", popDown, false);
}

function addBook() {
    addHeader();
    var book = getEl("Book");
    var target = getEl("popUp").childNodes[0];
    target.appendChild(book);
    getEl("close").addEventListener("click", popDown, false);
}

function popDown() {
    var el = getEl("popUp");
    var target = el.childNodes[0].childNodes[1];
    getEl("popup-info").appendChild(target);
    el.parentNode.removeChild(el);
}

