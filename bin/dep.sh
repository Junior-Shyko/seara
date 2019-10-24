#!/bin/bash

docker run --rm -it \
  -w /code \
  -v $(pwd):/code \
  -v /etc/passwd:/etc/passwd \
  -v ~/.ssh:/home/${USER}/.ssh \
  -u $(id -u ${USER}):$(id -g ${USER}) \
  deployer php vendor/bin/dep "$@"
