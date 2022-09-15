const amountField = document.getElementById("amount");
const priceField = document.getElementById("stock_price");
const walletField = document.getElementById("wallet");
const totalAmountField = document.getElementById("total_amount");
const fullPriceField = document.getElementById("full_price");

amountField.min = Math.ceil(1/priceField.value);
amountField.step = amountField.min;

const max = Math.max(Math.floor(walletField.value/priceField.value), totalAmountField.value);
amountField.max = max;

function validatePurchase(e) {
    e.preventDefault();

    let valid = true;

    if ((amountField.value * priceField.value) > walletField.value) {
        amountField.value = Math.ceil(walletField.value/priceField.value);
        valid = false;
    } else if ((amountField.value * priceField.value) < 1) {
        amountField.value = Math.ceil(1/priceField.value);
        valid = false;
    }

    return valid;
}

function change(e) {
    fullPriceField.value = "$" + Math.round(amountField.value * priceField.value)/100;
}
