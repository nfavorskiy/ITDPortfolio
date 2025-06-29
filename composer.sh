#!/bin/bash
docker run --rm -v "$(pwd)/src":/app composer "$@" --working-dir=/app