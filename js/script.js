const orderIds = document.querySelectorAll('.order-id');
const orderNames = document.querySelectorAll('.order-name');
const orderPrices = document.querySelectorAll('.order-price');
const orderQuantities = document.querySelectorAll('.order-quantity');
const orderCategories = document.querySelectorAll('.order-category');
const orderNotes = document.querySelectorAll('.order-note');
const noReceipt = document.querySelector('.no-receipt');

const addQuantityButtons = document.querySelectorAll('.add-quantity');
const reduceQuantityButtons = document.querySelectorAll('.reduce-quantity');
const addNoteButtons = document.querySelectorAll('.add-note');
const deleteNoteButtons = document.querySelectorAll('.delete-note');

const totalOrderQuantity = document.querySelector('.total-order-quantity');
const totalOrderPrice = document.querySelector('.total-order-price');

const saveOrder = document.querySelector('.save-order');
const restaurantId = document.querySelector('.restaurant-id');
const resetOrder = document.querySelector('.reset-order');
const seeReceipt = document.querySelector('.see-receipt');

noReceipt.addEventListener('input', () => {
  noReceipt.value = noReceipt.value.toUpperCase();
});

orderQuantities.forEach((orderQuantity, index) => {
  addQuantityButtons[index].addEventListener('click', () => {
    orderQuantity.textContent++;
    totalOrderQuantity.textContent++;
    totalOrderPrice.textContent = parseInt(totalOrderPrice.textContent) + parseInt(orderPrices[index].textContent);
  });
  reduceQuantityButtons[index].addEventListener('click', () => {
    if (orderQuantity.textContent !== '0') {
      orderQuantity.textContent--;
      totalOrderQuantity.textContent--;
      totalOrderPrice.textContent = parseInt(totalOrderPrice.textContent) - parseInt(orderPrices[index].textContent);
    }
  });
});

orderNotes.forEach((orderNote, index) => {
  addNoteButtons[index].addEventListener('click', () => {
    orderNote.classList.remove('d-none');
    addNoteButtons[index].classList.add('d-none');
    deleteNoteButtons[index].classList.remove('d-none');
  });
  deleteNoteButtons[index].addEventListener('click', () => {
    orderNote.value = '';
    orderNote.classList.add('d-none');
    addNoteButtons[index].classList.remove('d-none');
    deleteNoteButtons[index].classList.add('d-none');
  });
});

saveOrder.addEventListener('click', async () => {
  const orderCache = {
    "restaurant_id": restaurantId.textContent,
    "ordered": [],
    "no_receipt": (noReceipt.value === '') ? null : noReceipt.value
  };
  orderQuantities.forEach((orderQuantity, index) => {
    if (orderQuantity.textContent !== '0') {
      const orderedMenu = {
        id: orderIds[index].id,
        name: orderNames[index].textContent,
        price: parseInt(orderPrices[index].textContent),
        quantity: parseInt(orderQuantity.textContent),
        category: orderCategories[index].textContent,
        note: orderNotes[index].value
      }
      orderCache.ordered.push(orderedMenu);
    }
  });

  const options = {
    method: 'POST',
    body: JSON.stringify(orderCache)
  };
  const response = await fetch('https://restamanage.000webhostapp.com/api/order_caches/set.php', options);
  const responseJson = await response.json();
  console.log(responseJson.message);
});

resetOrder.addEventListener('click', async () => {
  const response = await fetch(`https://restamanage.000webhostapp.com/api/order_caches/reset.php?restaurant_id=${restaurantId.textContent}`);
  const responseJson = await response.json();
  console.log(responseJson.message);
  location.reload();
});

seeReceipt.addEventListener('click', async () => {
  saveOrder.click();
  window.location.href = 'receipt.php';
});

document.addEventListener('DOMContentLoaded', async () => {
  try {
    const response = await fetch(`https://restamanage.000webhostapp.com/api/order_caches/get.php?restaurant_id=${restaurantId.textContent}`);
    const responseJson = await response.json();
    if (responseJson.results) {
      if (responseJson.results.length) {
        const ordereds = JSON.parse(responseJson.results[0].ordered);
        ordereds.forEach((ordered) => {
          orderIds.forEach((orderId) => {
            if (orderId.id === ordered.id.toString()) {
              for (let i = 0; i < ordered.quantity; i++) {
                orderId.querySelector('.add-quantity').click();
              }
              if (ordered.note !== '') {
                orderId.querySelector('.add-note').click();
                orderId.querySelector('.order-note').value = ordered.note;
              }
              noReceipt.value = responseJson.results[0].no_receipt;
            }
          });
        });
      }
    }
    return;
  } catch (error) {
    console.log(error.message);
    return;
  }
});
