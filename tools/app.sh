#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
source "${DIR}/doc.sh"
source "${DIR}/common.sh"

checkDockerCompose() {
  if ! [ -f ${DIR}/../docker-compose.yml ]; then
    log "docker-compose.yml not exist." "error"
      printf "\e[0m\n"
    exit
  fi
}

createEnv() {
  if ! [ -f ${DIR}/.env.dist ]; then
    log "File ${DIR}/.env.dist not exist" "error"
      printf "\e[0m\n"
    exit
  fi
  cp ${DIR}/.env.dist ${DIR}/../backend/.env
}

setEnv() {
  if ! [ -f ${DIR}/../backend/.env ]; then
    log "File /backend/.env not exist" "error"
      printf "\e[0m\n"
    exit
  fi
  export $(grep -v '#' "$DIR/../backend/.env" | xargs)
}

init() {
  createEnv
  setEnv
  dockerBuild
  inastall
  printf "\e[0m\n"
  log "Project initialization completed. If success, enter the domain ${HOST} in hosts" "wait"
  printf "\e[0m\n"
}

dockerBuild() {
  checkDockerCompose
  log "Docker containers initializing." "wait"
  docker network create test68
  docker-compose build
  docker-compose up -d
  printf "\e[0m\n"
  log "NEXT" "info"
  printf "\e[0m\n"
}

inastall() {
  log "Composer install. Please, wait..." "wait"
  chmod 777 "${DIR}/../backend/"
  if [ -f "${DIR}/../backend/composer.lock" ]; then
    rm "${DIR}/../backend/composer.lock"
  fi
  composer install  --no-interaction --no-progress --prefer-dist
  chmod 775 "${DIR}/../backend/"
  log "NEXT" "info"
  printf "\e[0m\n"
  read -p "Fill the database with initial data? [y/n]" -n 1 -r
  if [[ ! $REPLY =~ ^[Yy]$ ]]; then
     return 1
  fi
    spinner
    fill
}

up() {
  down
  docker-compose up -d
}

down() {
  setEnv
  checkDockerCompose
  docker-compose down
}

build() {
  setEnv
  checkDockerCompose
  docker-compose build
}

php() {
  setEnv
  docker-compose exec php ${@:1}
}

composer() {
 exec composer ${@:1}
  if ! [ -f "${DIR}/../backend/composer.lock" ]; then
    printf "\e[0m\n"
    log "Composer installation problem. Installation aborted" "error"
    printf "\e[0m\n"
    exit
  fi
}

fill() {
  migrate
  seed
}

migrate() {
  log "Applying migrations" "wait"
  artisan migrate ${@:1}
}

seed() {
  log "Seed database" "wait"
  migrate
  artisan db:seed --force
}

make() {
  log "Create migration" "wait"
  artisan make:migration ${@:1}
}

exec() {
  setEnv
  docker exec -it "${APP_ENV}_${CONTAINER_NAME}_php" ${@:1}
}

artisan() {
  php php artisan ${@:1}
}

tests() {
  php php artisan test ${@:1}
}

case "$1" in
  "init")
    init;;
  "build")
    build;;
  "up")
    up;;
  "down")
    down;;
  "seed")
    seed;;
  "test"*)
    tests ${@:2};;
  "artisan"*)
    artisan ${@:2};;
  "make"*)
    make ${@:2};;
  "migrate"*)
    migrate ${@:2};;
  "php"*)
    php ${@:2};;
  "composer"*)
    composer ${@:2};;
  "exec"*)
    exec ${$:2};;
  *)
    doc;;
esac