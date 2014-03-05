#!/bin/bash

cwd=`pwd`

# stop httpd!
echo stoping the apache web server...

echo $cwd

#/usr/sbin/apachectl 

/h/u2/csc309h/fall/pub/lib/apache/apachectl -d $cwd/../conf -k stop
                                                                                                                             
# clean up
unset cwd
