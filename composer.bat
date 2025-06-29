@echo off
docker run --rm -v %cd%/src:/app composer %* --working-dir=/app