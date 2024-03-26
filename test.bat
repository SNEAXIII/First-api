@echo off
cd api-posts
cmd /c symfony serve -d
cd ../
cd http-client-api
cmd /c symfony serve -d
pause