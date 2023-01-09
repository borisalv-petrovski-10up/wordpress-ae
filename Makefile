SHELL := /bin/bash

deploy:
	wp core download
	gcloud app deploy app.yaml cron.yaml

.PHONY: deploy