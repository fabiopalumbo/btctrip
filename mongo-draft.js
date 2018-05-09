db.eval(function() {
	db.Airport.find({
		description : /Aeropuerto Internacional/i
	}).forEach(function(e) {
		var airportMatchs = e.description.match('^Aeropuerto Internacional (.*)');
		if (airportMatchs != null) {
			airportName = airportMatchs[1] + ' International Airport'; 
		} else {
			airportName = 'International Airport';
		}
		print(airportName);

		e.description = airportName;
		db.Airport.save(e);
	});
});


db.eval(function() {
	db.Airport.find({
		description : /Aeropuerto/i
	}).forEach(function(e) {
		var airportMatchs = e.description.match('^Aeropuerto (.*)');
		if (airportMatchs != null) {
			airportName = airportMatchs[1] + ' Airport'; 
		} else {
			airportName = 'Airport';
		}
		print(airportName);

		e.description = airportName;
		db.Airport.save(e);
	});
});

