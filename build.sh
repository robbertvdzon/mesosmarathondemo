#!/bin/bash

docker rm -f primetest

# build and run 2 apache container
docker build -t robbertvdzon/primetest ./apache
docker run -d -it -p 84:80 --name primetest robbertvdzon/primetest
