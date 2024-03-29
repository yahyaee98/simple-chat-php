APP := chat
CI_COMMIT_REF_SLUG?=$(shell cat .git/HEAD | cut -d '/' -f 3)
GIT_HEAD_REF := $(shell cat .git/HEAD | cut -d' ' -f2)
CI_COMMIT_SHORT_SHA?=$(shell cat .git/$(GIT_HEAD_REF) | head -c 7)

up:
	GIT_SHA=$(CI_COMMIT_SHORT_SHA) docker-compose up --build

install:
	composer install

test: install
	php vendor/bin/phpunit

docker:
	docker build \
          --build-arg GIT_SHA=$(CI_COMMIT_SHORT_SHA) \
          -t $(APP):$(CI_COMMIT_REF_SLUG) .
