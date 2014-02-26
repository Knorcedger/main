var express = require('express'),
	http = require('http'),
	db = require('./modules/db.js'),
	logger = require('./modules/logger.js'),
	requestDataParser = require('./modules/requestDataParser'),
	responseBuilder = require('./modules/responseBuilder'),
	apiAccessVerifier = require('./modules/apiAccessVerifier'),
	errorHandler = require('./modules/errorHandler'),
	nconf = require('nconf'),
	customValidations = require('./modules/customValidations')

/**
 * On application start
 */
var app = express();
//load config
nconf.file('./config.json');

var allowCrossDomain = function(req, res, next) {
	res.header('Access-Control-Allow-Origin', "*");
	res.header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
	res.header('Access-Control-Allow-Headers', 'Content-Type');
	res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
	next();
};

app.configure(function() {
	app.set('port', process.env.PORT || nconf.get('port'));
	app.use(express.bodyParser());
	app.use(express.cookieParser());
	app.use(express.methodOverride());
	app.use(allowCrossDomain);
	app.use(app.router);
	app.use(function (error, req, res, next){
		next();
	});
});

logger.init();

// initialize the db connection
db.init(app, nconf.get('mongoUrl'));
// setup the custom validations
customValidations();

/**
 * Application routes and middleware
 */
app.all('*', logger.start);
app.options("*", function(req, res) {
	res.send(200);
});

app.all('*', responseBuilder.init);
app.all('*', requestDataParser);
app.all('*', apiAccessVerifier);

// router.route(app);
// load routes

require('./v1/authentications/register.js').init(app);
require('./v1/authentications/login.js').init(app);
require('./v1/measurements/add.js').init(app);
require('./v1/users/measurements.js').init(app);
// require('./v1/authentications/register.js').init(app);
// require('./v1/authentications/logout.js').init(app);
// require('./v1/tags/edit.js').init(app);
// require('./v1/tags/add.js').init(app);
// require('./v1/tags/all.js').init(app);
// require('./v1/documents/add.js').init(app);
// require('./v1/documents/get.js').init(app);
// require('./v1/documents/edit.js').init(app);
// require('./v1/documents/delete.js').init(app);
// require('./v1/users/get.js').init(app);
// require('./v1/users/members.js').init(app);
// require('./v1/users/editMarket.js').init(app);
// require('./v1/users/editStatus.js').init(app);
// require('./v1/users/add.js').init(app);
// require('./v1/users/delete.js').init(app);
// require('./v1/users/edit.js').init(app);
// require('./v1/users/all.js').init(app);
// require('./v1/users/addavatar.js').init(app);
// require('./v1/markets/all.js').init(app);
// require('./v1/markets/add.js').init(app);
// require('./v1/markets/edit.js').init(app);
// require('./v1/markets/banks.js').init(app);
// require('./v1/markets/get.js').init(app);
// require('./v1/banks/get.js').init(app);
// require('./v1/banks/all.js').init(app);
// require('./v1/banks/documentadd.js').init(app);
// require('./v1/banks/addlogo.js').init(app);
// require('./v1/banks/add.js').init(app);
// require('./v1/banks/edit.js').init(app);
// require('./v1/photos/add.js').init(app);
// require('./v1/photos/delete.js').init(app);

// if user starts fooling around with urls...
app.all('*', function(req, res) {
	errorHandler.error(req, res, 'NOT_FOUND');
});

/**
 * Server start
 */
http.createServer(app).listen(app.get('port'), function(){
	GLOBAL.log('server.start.success', "Express server listening on port " + app.get('port'));
});

process.on('uncaughtException', function (err) {
	console.log('uncaughtException', err);
});