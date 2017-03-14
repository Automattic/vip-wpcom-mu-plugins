.PHONY: lint

test: lint

lint:
	git submodule update --init --recursive
	find . -name '*.php' -print0 | xargs -0 -n 1 -P 4 php -nl
