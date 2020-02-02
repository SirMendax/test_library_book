#!/usr/bin/env bash
sudo docker stop $(docker ps -a -q)
sudo docker rm -v $(sudo docker ps -aq -f status=exited)
sudo docker-compose build
sudo docker-compose up -d
