var images = [
  "https://www.royalcanin.com/~/media/Royal-Canin/Product-Categories/cat-adult-landing-hero.ashx",
  "https://www.petfinder.com/wp-content/uploads/2013/09/cat-black-superstitious-fcs-cat-myths-162286659.jpg",
  "https://upload.wikimedia.org/wikipedia/commons/4/4d/Cat_March_2010-1.jpg"
]

var heroImage = document.getElementByClassName("hero-image");
var i = 0;

setInterval(function() {
      heroImage.style.backgroundImage = "url(" + images[i] + ")";
      i = i + 1;
      if (i == images.length) {
      	i =  0;
      }
}, 1000