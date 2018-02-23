const Clarifai = require('clarifai');

// initialize with your api key. This will also work in your browser via http://browserify.org/
window.clarifai = new Clarifai.App({
 apiKey: 'dad91c874b1b4c18b6e00f5c4d24a0b7'
});
window.Clarifai = Clarifai;