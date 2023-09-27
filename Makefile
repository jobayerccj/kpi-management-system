#####
## Build images (and ensure they are up to date)
build:
	@echo 'Pull & build required images'
	docker-compose build

#####
## Start containers
start:
	@echo 'Starting containers'
	@if ! docker network inspect kpinetwork > /dev/null 2>&1; then \
		echo 'Creating network kpinetwork'; \
		docker network create kpinetwork; \
	fi
	@docker-compose up -d
	@docker network connect kpinetwork dc.kpiubuntu

#####
## Stop containers & remove docker networks
stop:
	@echo 'Stopping containers'
	@if docker-compose down; then \
    	if [ $$(docker network inspect -f '{{.Containers}}' kpinetwork | jq 'length') -eq 0 ]; then \
    		echo 'Remove network kpinetwork'; \
    		docker network rm kpinetwork; \
    	else \
    		echo 'Network kpinetwork is still in use by containers'; \
    	fi \
    fi


#####
## Open container
exec:
	@echo 'Open container'
ifeq ($(dc),kpiubuntu)
	docker exec -it -w /var/www/html dc.$(dc) /bin/bash
else
	docker exec -it dc.$(dc) /bin/bash
endif

#####
## Display available make tasks
help:
	@echo 'Recipes List:'
	@echo ''
	@echo 'make <recipes>'
	@echo ''
	@echo '+-----------------+--------------------------------------------------------------------+'
	@echo '| Recipes         | Utility                                                            |'
	@echo '+-----------------+--------------------------------------------------------------------+'
	@echo '| start           | Start containers (Also builds & pull images, if there not exists)  |'
	@echo '| stop            | Stop containers & remove docker networks                           |'
	@echo '| build           | Re/Build containers                                                |'
	@echo '| exec dc=NAME    | Open container                                                     |'
	@echo '+-----------------+--------------------------------------------------------------------+'
	@echo ''