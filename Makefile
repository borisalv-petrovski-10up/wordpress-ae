SHELL := /bin/bash

deploy:
	wp core download --force
	gcloud app deploy app.yaml cron.yaml

.PHONY: deploy