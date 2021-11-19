const orderSubTotals = document.querySelectorAll('.order-sub-total');
const orderQuantities = document.querySelectorAll('.order-quantity');

const totalOrderQuantity = document.querySelector('.total-order-quantity');
const totalOrderPrice = document.querySelector('.total-order-price');

document.addEventListener('DOMContentLoaded', () => {
  orderQuantities.forEach((orderQuantity) => {
    totalOrderQuantity.textContent = parseInt(totalOrderQuantity.textContent) + parseInt(orderQuantity.textContent);
  });
  orderSubTotals.forEach((orderSubTotal) => {
    totalOrderPrice.textContent = parseInt(totalOrderPrice.textContent) + parseInt(orderSubTotal.textContent);
  });
});
