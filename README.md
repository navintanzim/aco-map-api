# Ant colony optimization workshop for solving a travelling salesman problem

[Русская версия](docs/README_ru.md)

## Table of contents

* [Introdution](#goal)
* [Demo](#demo)
* [Installing ang running on Docker](#docker)
* [Installing ang running on OpenServer](#openserver)
* [Tips](#tips)


---

## Introdution <span id="goal"></span>

This workshop gives you a web-application with user interface to work with this [ACO library](https://github.com/mgrechanik/ant-colony-optimization).

All details about aco algorithm you can find in the docs of that library.

The information about graph comes from an image file.

You can set all settings and parameters used by aco algorithm and see the result of the calculation.

This application is intended to be run locally, on user's PC.

---

## Demo <span id="demo"></span>

[Video demo](https://www.youtube.com/watch?v=0sNPC6pUG9U)

![Ant colony optimization workshop](https://raw.githubusercontent.com/mgrechanik/aco-workshop-for-tsp/main/docs/aco_workshop_demo.jpg "Ant colony optimization workshop")



	
---
    
## Installing ang running on Docker <span id="docker"></span>

If you are using Docker in your work then the application is ready to be run with it.


Download app's files with a Git
```
git clone git@github.com:mgrechanik/aco-workshop-for-tsp.git
```

If you do not have Git, download files from **Code --> Dowload Zip** at this github page and unzip it.

Go to the directory with the application
```
cd aco-workshop-for-tsp
```

You need to set rigts, you need to do it one-time.
```
chmod -R o+w ./web/uploads
```

That is all, application is ready to be launched, so do it with this command:
```
docker compose up -d
```

And by opening address http://localhost:8000 in your web browser you will see the main page of the application.

When you decide to stop working, just run

```
docker compose down
```


---

## Installing ang running on OpenServer <span id="openserver"></span>

If you are not familiar with Docker, you can run it on any webserver with PHP (version >= 8.0 ) and Composer.
Because the application is just a PHP app on Yii2 framework.

For example, I will show you how to install and run it on [OpenServer](https://ospanel.io/)

1) Download and install OpenServer, I have it installed in D:\OpenServer

2) In the directory D:\OpenServer\domains create new directory, say **aco.front**.

3) Download application files from **Code --> Dowload Zip** at this github page and unzip it. 
Your directory ```D:\OpenServer\domains\aco.front``` should look like:
```
assets
commands
config
...
```

4) Now you need to set a couple of things. The steps are demonstrated on the next image.
![installing on OpenServer](https://raw.githubusercontent.com/mgrechanik/aco-workshop-for-tsp/main/docs/os_all.jpg "installing on OpenServer")

5) Go to Settings

6) At modules tab you set PHP version to 8.0 or higher.

7) At the domains tab you set new name to **aco.front**, and it's directory to - **aco.front/web** , click "Add" button.

8) We get our domain in the list like on the image and click "Save"

9) Go to PHP settings

10) Set the work timeout from 30 (seconds) to 300 for example

11) Lanch a web server

12) Go to console

13) Run two commands in it
```
cd domains\aco.front

composer install
```

14) That is all, application is ready to be used, just go to the next address in your web browser:

http://aco.front/

---

## Tips <span id="tips"></span>

#### How to create an image with a graph <span id="tips-image-create"></span>

There are two types of strategies how we find nodes of a graph on an image.

The first strategy is this: the color of nodes are different from background color (color of the top left pixel).
Take a brush in your image editor with 10px (so they are clearly seen) diameter and draw nodes.

The second strategy is when you know the exact color, in RGB format, which is present on the node.
It is handy when you have some others image and draw you nodes on it.

This application comes with two example images who represent each type.