APP := chat
CI_COMMIT_REF_SLUG?=$(shell cat .git/HEAD | cut -d '/' -f 3)

test:
	php vendor/bin/phpunit

docker:
	docker build \
          -t $(APP):$(CI_COMMIT_REF_SLUG) .
