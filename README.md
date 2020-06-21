# Simple chat
[![Build Status](https://travis-ci.org/yahyaee98/simple-chat-php.svg?branch=master)](https://travis-ci.org/yahyaee98/simple-chat-php)

a Simple chat backend written in PHP.

## 🚀 Quickstart
Just run `docker-compose up`.

## 📄 API documentation
You can check the full API documentation in [Swagger UI](https://yahyaee98.github.io/simple-chat-php/api).

I've deployed the code on [chat.cloud.soheil.io](https://chat.cloud.soheil.io) and that is configured in the Swagger UI. Feel free to play with the APIs in the Swagger UI! ✨

## 🧪 Tests
I've included some tests for the `Chat` service. Just run `make test` to see them working 😁.

## 😈 Behind the scenes
- My approach to managing a large codebase was to group different business logics under their corresponding namespace under the `App\Services` namespace.
- It's best to keep those `Service`s loosely-coupled and have as much less dependency on other pieces of code as possible.
- I preferred to use data mappers instead of the models that Lumen provides by default, but to keep the time window short, I stuck to the default active record pattern which was provided by the framework.

Simple chat is an open-sourced software licensed under the MIT license.
