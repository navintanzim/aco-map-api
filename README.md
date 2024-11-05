# Ant colony optimization workshop for solving a travelling salesman problem

This is the second part (map api) of the ACO solving TSP system.

First part: https://github.com/navintanzim/acov2/tree/main

To run the map api part, run the command: "php yii serve" in your shell. 

## Tips <span id="tips"></span>

#### How to create an image with a graph <span id="tips-image-create"></span>

There are two types of strategies how we find nodes of a graph on an image.

The first strategy is this: the color of nodes are different from background color (color of the top left pixel).
Take a brush in your image editor with 10px (so they are clearly seen) diameter and draw nodes.

The second strategy is when you know the exact color, in RGB format, which is present on the node.
It is handy when you have some others image and draw you nodes on it.

This application comes with two example images who represent each type.

A demo video showing the whole process is given at the file: demo video.wmv in the root directory (https://github.com/navintanzim/acov2/blob/main/demo%20video.wmv)

Built by Mashrure Tanzim