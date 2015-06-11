#!/bin/bash
#cd /home/tirea/tirea.learnnavi.org/_posts && for file in *.post; do echo -ne \<option value\=\"$file\"\>$file\<\/option\>; done
for file in /home/tirea/tirea.learnnavi.org/_posts/*.post; do echo -ne \<option value\=\"$file\"\>$file\<\/option\>; done
