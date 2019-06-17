#!/bin/bash

thepwd=$(pwd)

if ! [ -x $(command -v npm) ]; then
	return;
fi

npm uninstall -g eslint-plugin-webdevstudios # Remove old one

if [[ $thepwd == *".composer"* ]]; then
	npm install -g eslint
	npm install -g git://git@github.com:WebDevStudios/eslint-plugin-webdevstudios.git
else
	npm install eslint
	npm install git://git@github.com:WebDevStudios/eslint-plugin-webdevstudios.git
fi

