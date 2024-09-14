// tang giam so luong 
const increase = document.querySelector('.increase'),
    reduce = document.querySelector('.reduce');

var quantify = document.getElementById('input-num');


let price = document.querySelector('#price'); 
let numberprice = parseFloat(price.innerHTML); // đưa giá tiền về kiểu số int
let floatprice = numberprice.toLocaleString('en-US');
price.innerHTML = floatprice;

let a = 1;
increase.addEventListener("click", function () {
    a++;
    totalprice = a * numberprice; //tinh tong gia tien
    floattotalprice = totalprice.toLocaleString('en-US');
    price.innerHTML = floattotalprice; // thay doi gia tien
    quantify.value = a; //thay đổi value trong input để lấy số lượng sản phẩm
    
});
reduce.addEventListener("click", function () {
    if (a > 1) {
        a--;
        
        totalprice -= numberprice ; //tinh tong gia tien
        floattotalprice = totalprice.toLocaleString('en-US');
        price.innerHTML = floattotalprice; // thay doi gia tien
        quantify.value = a; //thay đổi value trong input để lấy số lượng sản phẩm
    }
    else {
        a = 1;
       
        quantify.value = 1;
        
    }

})