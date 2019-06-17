#!/bin/bash

thepwd=$(pwd)

if ! [ -x $(command -v npm) ]; then
	return;
fi

if [[ $thepwd == *".composer"* ]]; then
	npm update -g git://git@github.com:WebDevStudios/eslint.git
else
	npm update git://git@github.com:WebDevStudios/eslint.git
fi
