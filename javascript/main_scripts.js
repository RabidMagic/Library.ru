window.addEventListener("load", pageLoaded, false);

function addEvents() {
    if (getEl("button_login")) {
        getEl("button_login").addEventListener("click", popUp,false);
    }
    if (getEl("button_reg")) {
        getEl("button_reg").addEventListener("click", popUp, false);
    }
}

function addLogin() {
    var log = document.createElement("tr");
    log.innerHTML = "<td>Логин: </td><td><input name='login' type='text'></td>";
    var pas = document.createElement("tr");
    pas.innerHTML = "<td>Пароль: </td><td><input type='password' name='password'></td>";
    var table = document.createElement("table");
    table.appendChild(log);
    table.appendChild(pas);  
    var but = document.createElement("input");
    but.type = "submit";
    but.value = "Войти";
    var form = document.createElement("form");
    form.action = "login.php";
    form.method="post";
    form.appendChild(table);
    form.appendChild(but);
    var close = document.createElement("div");
    close.id = "close";
    close.innerHTML = "X";
    var div = document.createElement("div");
    div.id = "log";
    div.appendChild(close);
    div.appendChild(form);
    var login = document.createElement("div");
    login.id = "pop-up";
    login.appendChild(div);
    var container = getEl("container");
    document.body.insertBefore(login, container);
    close.addEventListener("click", popDown, false);
}

function addReg() {
    var x;
    var log = document.createElement("tr");
    log.innerHTML = "<td>Ваш логин:</td><td><input type='text' name='login' id='login' size='16' maxlength='16'></td><td id='img_login'></td>";
    var pas = document.createElement("tr");
    pas.innerHTML = "<td>Ваш пароль:</td><td><input type='password' name='password' id='password' size='16' maxlength='16'></td><td id='img_password'></td>";
    var pas2 = document.createElement("tr");
    pas2.innerHTML = "<td>Повторите пароль:</td><td><input type='password' name='password2' id='password2' size='16' maxlength='16'></td><td id='img_password2'></td>";
    var birth = document.createElement("tr");
    birth.innerHTML = "<td>Ваша дата рождения:</td>";
    var td = document.createElement("td");
    var day = "<select name='reg-b-day' id='reg-b-day'><option disabled selected>ДД</option>";
    for (var d = 1; d < 32; d++) {
        if (d < 10) {
            x = "0" + d;
        } else { x = d;
        }
        day += "<option>" + x + "</option>";
    }
    day += "</select>";
    var mon = "<select name='reg-b-month' id='reg-b-month'><option disabled selected>ММ</option>";
    for (var m = 1; m < 13; m++) {
        if (m < 10){
            x = "0" + m;
        } else {
            x = m;
        }
        mon += "<option>" + x + "</option>";
    }
    mon += "</select>";
    var date = new Date();
    var miny = date.getFullYear() - 80;
    var maxy = date.getFullYear() - 10;
    var year = "<select name='reg-b-year' id='reg-b-year'><option disabled selected>ГГГГ</option>";
    for (miny; miny <= maxy; miny++) {
        year += "<option>" + miny + "</option>";
    }
    year += "</select>";
    td.innerHTML = day + mon + year;
    birth.appendChild(td);
    td = document.createElement("td");
    td.id = "img_birth";
    birth.appendChild(td);
    var gen = document.createElement("tr");
    gen.innerHTML = "<td>Ваш пол</td><td><input type='radio' name='gender' value='Мужской'>Мужской<br><input type='radio' name='gender' value='Женский'>Женский</td>";
    var mail = document.createElement("tr");
    mail.innerHTML = "<td>Ваш e-mail</td><td><input type='text' name='email' id='email'></td><td id='img_email'></td>";
    var rob = document.createElement("tr");
    rob.innerHTML = "<td>Вы робот?</td><td><input type='radio' name='checkbot' value='yes' checked>Да<br><input type='radio' name='checkbot' value='no'>Нет</td>";
    var table = document.createElement("table");
    table.appendChild(log);
    table.appendChild(pas);
    table.appendChild(pas2);
    table.appendChild(birth);
    table.appendChild(gen);
    table.appendChild(mail);
    table.appendChild(rob);
    var h = document.createElement("h1");
    h.innerHTML = "Регистрация";
    var but = document.createElement("input");
    but.type = "submit";
    but.value = "Зарегистрироватся";
    but.name = "reg";
    var form = document.createElement("form");
    form.action = "reg_scr.php";
    form.method = "post";
    form.name = "reg";
    form.appendChild(h);
    form.appendChild(table);
    form.appendChild(but);
    var close = document.createElement("div");
    close.id = "close";
    close.innerHTML = "X";
    var div = document.createElement("div");
    div.id = "reg";
    div.appendChild(close);
    div.appendChild(form);
    var login = document.createElement("div");
    login.id = "pop-up";
    login.appendChild(div);
    var container = getEl("container");
    document.body.insertBefore(login, container);
    close.addEventListener("click", popDown, false);
    var inputs = document.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener("change", checkReg, false);
    }
    var opt = document.getElementsByTagName("select");
    for (var i = 0; i < opt.length; i++) {
        opt[i].addEventListener("change", checkBirth, false);
    }
}

function getEl(id) {
    return document.getElementById(id);
}

function checkJavaScript() {
    if (document.getElementById){
        document.getElementById("button_login").innerHTML = "Войти";
        document.getElementById("button_reg").innerHTML = "Регистрация";
    }
}
function popUp() {
    var choice = this.innerHTML;
    switch (choice) {
        case "Войти": 
            addLogin();
            break
        case "Регистрация":
            addReg();
            break
    }
}

function popDown() {
    var el = getEl("pop-up");
    el.parentNode.removeChild(el);
}

function checkTags() {
    var page = window.location.pathname;
    if (page == "/") {
        page = "/index.php";
    }
    switch (page) {
        case "/index.php":
            getEl("link1").style.margin = "0 0 0 0";
            break
        case "/catalog.php" :
            getEl("link2").style.margin = "0 0 0 115px";
            break
        case "/guestbook.php" :
            getEl("link3").style.margin = "0 0 0 230px";
            break
    }  
}

function pageLoaded(){
    checkTags();
    checkJavaScript();
    addEvents();
}

function checkReg() {    
    var yes = "<img src='img/yes.png'>";
    var no = "<img src='img/no.png'>";
    var loading = "<img src='img/loading.gif'>";
    var obj = this;
    var name = obj.getAttribute("name");
    var img = "img_" + name;
    img = getEl(img);
    img.innerHTML = loading;
    var params = "check=" + name + "&" + name + "=" + obj.value;
    var request = false;
    var res;
    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        request = new ActiveXObject("Microsoft.HMLHTTP");
    }
    request.open('POST','/ajax_reg.php',true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(params);
    request.onreadystatechange = function () {
        if (this.readyState === 4){
            res = request.responseText;
            if (res == 1) {
                img.innerHTML = yes;
            } else {
                img.innerHTML = no + "<p class='message'>" + res + "</p>";
                img.childNodes[0].addEventListener("mouseenter", upMessage, false);
            }
        }
    };
}

function checkBirth() {
    var yes = "<img src='img/yes.png'>";
    var no = "<img src='img/no.png'>";
    var loading = "<img src='img/loading.gif'>";
    var img = getEl("img_birth");
    img.innerHTML = loading;
    var day = getEl("reg-b-day").options[getEl("reg-b-day").selectedIndex].value | "";
    var month = getEl("reg-b-month").options[getEl("reg-b-month").selectedIndex].value | "";
    var year = getEl("reg-b-year").options[getEl("reg-b-year").selectedIndex].value | "";
    var params = "check=birth&reg-b-month=" + month + "&reg-b-day=" + day + "&reg-b-year=" + year;
    var request = false;
    var res;
    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        request = new ActiveXObject("Microsoft.HMLHTTP");
    }
    request.open('POST','/ajax_reg.php',true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(params);
    request.onreadystatechange = function () {
        if (this.readyState === 4){
            res = request.responseText;
            if (res == 1) {
                img.innerHTML = yes;
            } else {
                img.innerHTML = no + "<p class='message'>" + res + "</p>";
                img.childNodes[0].addEventListener("mouseenter", upMessage, false);
            }
        }
    };
}

function upMessage() {
    var mes = this.parentNode;
    mes.removeEventListener("mouseenter",upMessage);
    mes.childNodes[0].addEventListener("mouseout", downMessage, false);
    mes.childNodes[0].addEventListener("mousemove", moveMessage, false);
    mes.childNodes[1].style.display = "block";
    var mouse_x = 0;
    var mouse_y = 0;
    if (document.attachEvent != null) {
        mouse_x = window.event.clientX;
        mouse_y = window.event.clientY;
    } else if (!document.attachEvent && document.addEventListener) {
        mouse_x = event.clientX;
        mouse_y = event.clientY;
    }
    mes.childNodes[1].style.left = mouse_x + "px";
    mes.childNodes[1].style.top = mouse_y + "px";
}

function downMessage() {
    var mes = this.parentNode;
    mes.childNodes[0].removeEventListener("mousemove", moveMessage);
    mes.addEventListener("mouseenter", upMessage, false);
    mes.childNodes[1].style.display = "none";
}

function moveMessage() {
    var target = this.parentNode.childNodes[1];
    var mouse_x = 0;
    var mouse_y = 0;
    if (document.attachEvent != null) {
        mouse_x = window.event.clientX;
        mouse_y = window.event.clientY;
    } else if (!document.attachEvent && document.addEventListener) {
        mouse_x = event.clientX;
        mouse_y = event.clientY;
    }
    target.style.left = mouse_x + "px";
    target.style.top = mouse_y + "px";
}
