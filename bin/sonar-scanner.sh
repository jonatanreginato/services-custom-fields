#!/bin/bash

docker run \
  --rm \
  --network=host \
  -e SONAR_HOST_URL="http://localhost:9000" \
  -e SONAR_SCANNER_OPTS="-Dsonar.projectKey=sqp_8c8e7fd7dba5303b4253c48ef2bb7435378e2c98" \
  -e SONAR_TOKEN="squ_e9b1b40bc8aa6a0f83f068400b00227fe9f53505" \
  -v "$(pwd):/usr/src" sonarsource/sonar-scanner-cli -X
