/* FireBase */

import * as firebase from "firebase";
window.firebase = firebase;

const config = {
    apiKey: "AIzaSyApQZFk8SuoKO4M9P2UHRlpQZMI0be7s8o",
    authDomain: "graduation-project-168208.firebaseapp.com",
    databaseURL: "https://graduation-project-168208.firebaseio.com",
    projectId: "graduation-project-168208",
    storageBucket: "graduation-project-168208.appspot.com",
    messagingSenderId: "789717465995"
};
window.firebase.initializeApp(config);



