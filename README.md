# About

This repository contains solutions for technical tasks for Geomiq interview.

## Why PHP?

This test is for a Senior PHP engineer position, thus PHP was chosen for the solution

## Why Lumen?

Geomiq uses Laravel internally, Laravel however is too much for such a small application.
I chose Lumen as it's significantly smaller than Laravel (performance overhead, cognitive overhead), uses Laravel components - mainly the console components which help out a ton with the tasks presented.
If I didn't use Lumen I would have to handle CLI input myself or through the usage of another library. Lumen does not have much of an overhead in comparison to such libraries at the same time saving me time; thus the choice.

# Prerequirements

This setup uses docker to spin up php 7.3 and mysql 5.6 containers

Requirements:

- [Docker + docker-compose installed](https://docs.docker.com/install/)

## Setting up

### 1. Building the app

This step will:

- build images for php and mysql containers
- install dependencies for the PHP app

Execute:

```bash
./run.sh install
```

### 2. Running the app

Execute:

```bash
./run.sh dev
```
