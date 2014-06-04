function phpPost(param) {
    var request = false;
    var res;
    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        request = new ActiveXObject("Microsoft.HMLHTTP");
    }  
    request.open('POST','/test_reg.php',true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(param);
    request.onreadystatechange = function () {
        if (this.readyState === 4){
            res = request.responseText;
            return res;
        }
    };
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
function popUp(choice) {
    switch (choice) {
        case "Войти": 
           getEl("login_pop-up").style.visibility = "visible";
            break
        case "Регистрация":
            getEl("reg_pop-up").style.visibility = "visible";
            break
    }
}

function popDown() {
    getEl("login_pop-up").style.visibility = "hidden";
    getEl("reg_pop-up").style.visibility = "hidden";
}

function checkTags() {
    var page = window.location.pathname;
    switch (page) {
        case "/index.php" :
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

function loginCheck(choice){   
    var yes = "<img src='img/yes.png' alt='yes'>";
    var no = "<img src='img/no.png' alt='no' onmouseenter='message('up');' onmouseleave='message('down');'><p id='message'>";
    var params = "";
    var target = choice + '_message';
    switch (choice){ 
        case "login" :
            params = params + 'check=login&login=' + getEl('login').value;
            break
        case "password" :
            params = params + 'check=password&password=' + getEl('password').value;
            getEl('password2_message').innerHTML = '';
            break
        case "password2" :
            params = params + 'check=password2&password2=' + getEl('password2').value + '&password=' + getEl('password').value;
            break
        case "email" :
            params = params + 'check=email&email=' + getEl(email).value;
            break
    }
    
    var request = false;
    var res;
    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        request = new ActiveXObject("Microsoft.HMLHTTP");
    }  
    request.open('POST','/test_reg.php',true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(params);
    request.onreadystatechange = function () {
        if (this.readyState === 4){
            res = request.responseText;
            if (res == 1) {
                getEl(target).innerHTML = yes;
            } else {
                getEl(target).innerHTML = res;
            }
        }
    };
}

function pageLoaded(){
    checkTags();
    checkJavaScript();
}

function messageUp(way) {
    alert('ахтунг');
    if (way === 'up') {
        getEl('message').style.visibility = 'visible';
    } else {getEl('message').style.visibility = 'hidden';
    }
}
