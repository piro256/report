<?php
/* Подключение к серверу MySQL */ 

$link_to_mysql = mysqli_connect( 
            'localhost',  /* Хост, к которому мы подключаемся */ 
            'root',       /* Имя пользователя */ 
            '',   /* Используемый пароль */
            'reports');     /* База данных для запросов по умолчанию */
mysqli_set_charset($link_to_mysql, "utf8");
if (!$link_to_mysql) { 
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error()); 
   exit; 
} 

//config flag