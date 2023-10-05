// Sample inventory data (for testing)
let inventory = [];

// DOM elements
const addItemForm = document.getElementById("addItemForm");
const itemNameInput = document.getElementById("itemName");
const itemQuantityInput = document.getElementById("itemQuantity");
const inventoryList = document.getElementById("inventoryList");

// Function to add an item to the inventory
function addItem() {
    const itemName = itemNameInput.value;
    const itemQuantity = parseInt(itemQuantityInput.value);

    if (itemName && !isNaN(itemQuantity)) {
        // Create a new item object
        const newItem = {
            name: itemName,
            quantity: itemQuantity,
        };

        // Add the item to the inventory
        inventory.push(newItem);

        // Clear input fields
        itemNameInput.value = "";
        itemQuantityInput.value = "";

        // Update the inventory list
        updateInventoryList();
    }
}

// Function to update the inventory list
function updateInventoryList() {
    // Clear the current list
    inventoryList.innerHTML = "";

    // Add items to the list
    inventory.forEach((item, index) => {
        const listItem = document.createElement("li");
        listItem.innerHTML = `
            <span>${item.name}</span>
            <span>${item.quantity}</span>
            <button onclick="removeItem(${index})">Remove</button>
        `;
        inventoryList.appendChild(listItem);
    });
}

// Function to remove an item from the inventory
function removeItem(index) {
    inventory.splice(index, 1);
    updateInventoryList();
}

// Event listener for form submission
addItemForm.addEventListener("submit", (e) => {
    e.preventDefault();
    addItem();
});

// Initialize the inventory list
updateInventoryList();
