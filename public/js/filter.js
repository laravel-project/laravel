//We already have a limitTo filter built-in to angular,
//let's make a startFrom filter
m.filter('startFrom', function() {
  return function(input, start) {
    start = +start; //parse to int
    return input.slice(start);
  }
});
