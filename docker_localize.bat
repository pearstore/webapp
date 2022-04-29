@echo off
docker-compose down
docker-compose build --force-rm
docker-compose up --force-recreate
docker-compose down