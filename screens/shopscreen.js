// Function to add items to sessionStorage
function addToCart(itemName, price) {
    // Get the existing cart items from sessionStorage or initialize an empty array
    var cartItems = JSON.parse(sessionStorage.getItem("cartItems")) || [];
  
    // Push the new item to the cartItems array
    cartItems.push({ itemName: itemName, price: price });
  
    // Store the updated cartItems array back to sessionStorage
    sessionStorage.setItem("cartItems", JSON.stringify(cartItems));
  }
  
  // Get all "Add to Cart" buttons
  var addToCartButtons = document.querySelectorAll(".card button");
  
  // Loop through each button and add click event listener
  addToCartButtons.forEach(function(button) {
    button.addEventListener("click", function(event) {
      // Get the parent card of the clicked button
      var card = event.target.closest(".card");
  
      // Get the item name and price from the card
      var itemName = card.querySelector("h3").textContent;
      var price = card.querySelector(".price").textContent;
  
      // Call the addToCart function with item name and price
      addToCart(itemName, price);
  
      // Optionally, you can add more logic here such as updating the total price
    });
  });
  