#!/bin/bash

rm -rf build/code
docker build -t seara_build --network host .

CONTAINER_ID=$(docker create -ti seara_build)
docker cp ${CONTAINER_ID}:/code ./build
docker rm -f ${CONTAINER_ID}
