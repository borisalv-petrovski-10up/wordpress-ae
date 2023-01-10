SHELL := /bin/bash

create-wp-provisioning:
	gcloud deployment-manager deployments create ae-wordpress-deployment \
		--project sk-borislav --config ./deployment-provisioning/resources.yaml

update-wp-provisioning:
	gcloud deployment-manager deployments update ae-wordpress-deployment \
		--project sk-borislav --config ./deployment-manager/resources.yaml

delete-wp-provisioning:
	gcloud deployment-manager deployments delete ae-wordpress-deployment

deploy:
	wp core download --force
	gcloud app deploy app.yaml cron.yaml

.PHONY: create-wp-provisioning update-wp-provisioning delete-wp-provisioning deploy