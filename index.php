<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Библиотека</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="img/logo.ico">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    </head>
    <body>
        <section id="container">
            <?php include 'header.php'; ?>
            <article id="main">
                <div class="news">
                    <div><img src="img/book.jpg" alt="картинка"></div>
                    <div class="description">
                        <h1>Название книги</h1>
                        <h3>Автор</h3>
                        <p>Очень большой текст, который описывает новую книгу... бла-бла-бла</p>
                    </div>
                </div>
                <div class="news">
                    <div><img src="img/1000028.jpg" alt="Страж"></div>
                    <div class="description">
                        <h1><a href="books/strag.php">Страж</a></h1>
                        <h3>Александр Пехов</h3>
                        <p>Там, где со злом не могут справиться князья и клирики, инквизиторы и колдуны, – на помощь зовут воспитанников Братства стражей. Людей с даром, способных видеть незримое и остановить темных сущностей. Людвиг ван Нормайенн – один из них. Вольный охотник за порождениями тьмы, он путешествует из княжества в княжество, избавляя мир от злобных душ. Его ждет работа везде, где происходят необъяснимые события, жестокий мор и странные, неожиданные смерти. <a class="links" href="books/strag.php">Подробнее</a></p>
                    </div>
                </div>
                <div class="news">
                    <div><img src="img/book.jpg" alt="картинка"></div>
                    <div class="description">
                        <h1>Название книги</h1>
                        <h3>Автор</h3>
                        <p>Очень большой текст, который описывает новую книгу... бла-бла-бла</p>
                    </div>
                </div>
                
            </article>
            <?php include 'footer.php'; ?>
        </section>  
    </body>
</html>
