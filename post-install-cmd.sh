#!/bin/bash

thepwd=$(pwd)

if ! [ -x $(command -v npm) ]; then
	return;
fi

if [[ $thepwd == *".composer"* ]]; then
	npm install -g eslint eslint-config-wordpress git://git@github.com:WebDevStudios/eslint-plugin-webdevstudios.git
fi

