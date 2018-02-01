# GiphySilex
- A RESTful api to access GIPHY via Silex API.
- Live accessible API is hosted at below location

#`https://giphysilex.herokuapp.com`

### Endpoints
#### `/` - GET
- Requires a valid `token` in header

#### `/create` - POST
- Requires valid `email` address to attach to the token
- You can also provide `name` but it is optional
- Get the token from the result because you would have to pass thatn in future API calls.
- All tokens will be valid until 1 day only

#### `/search/searchTerm` - GET
- Requires valid `token` in header
- Pass whatever you want to search on GIPHY as search term

### Commands
- Run it locally
`php -S localhost:8000`

- Heroku commands
```
heroku login
heroku create
heroku --help
git push heroku master
```