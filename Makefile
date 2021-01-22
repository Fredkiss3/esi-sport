sc := php bin/console

#test:
#	$(sc) make:functional-test

start:
	php -S localhost:8000 -t public

genadmin:
	$(sc) make:admin:dashboard

crud:
	$(sc) make:admin:crud

entity:
	$(sc) make:entity

controller:
	$(sc) make:controller

migration:
	$(sc) make:migration

migrate:
	$(sc) doctrine:migrations:migrate

ftest:
	$(sc)  make:functional-test
utest:
	$(sc) make:unit-test
#test:
	# Example : make test unit|functionnal
#	$(sc) make:$(filter-out $@,$(MAKECMDGOALS))-test
#greet:
#	@echo Hello $(filter-out $@,$(MAKECMDGOALS))

#%: # thanks to chakrit
#	@:    # thanks to William Pursell
