#!/usr/bin/.env bash

doc() {
   printf "

   ------ Управление ./tools/app.sh [options] [arguments] ------

options:
   init                          - инициализация нового проекта
   build                         - построить контейнер
   up                            - запустить контейнер
   down                          - остановить контейнер
   seed                          - заполнить бд стартовыми данными
   test <arguments>              - запуск тестов
   artisan <arguments>           - команды artisan
   migrate <arguments>           - миграции
   composer <arguments>          - композер
   php <arguments>               - PHP команды в контейнере
   exec <arguments>              - произвольные команды в контейнере


   "
}