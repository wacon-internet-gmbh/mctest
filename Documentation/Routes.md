# Routes
## Basic Routing setup
```
routeEnhancers:
PageTypeSuffix:
    map:
      '.json': 20240902
  SimpleQuiz:
    type: Extbase
    extension: Simplequiz
    plugin: Simplequiz
    defaultController: Quiz::show
    routes:
      - routePath: '/'
        _controller: 'Quiz::show'
      - routePath: '/solving/'
        _controller: 'Quiz::solving'
      - routePath: '/answering/'
        _controller: 'Quiz::answering'
      - routePath: '/complete/'
        _controller: 'Quiz::complete'
```
