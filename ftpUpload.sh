#!/bin/bash

file=$1
lftp -e "put -O /public_html/web2/ $file" -u ejohn,P@ssw0rd12 digitech.ncl-coll.ac.uk
