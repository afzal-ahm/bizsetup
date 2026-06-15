<?php
if (!isset($order)) die();
?>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<style>
/* LOAD GOOGLE FONT */
/* latin-ext */
@font-face {
  font-family: 'Oxygen';
  font-style: normal;
  font-weight: 400;
  src: local('Oxygen'), local('Oxygen-Regular'), url(https://fonts.gstatic.com/s/oxygen/v5/IIPDrwV5KNJo5-LaFlLy2fesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
  unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Oxygen';
  font-style: normal;
  font-weight: 400;
  src: local('Oxygen'), local('Oxygen-Regular'), url(https://fonts.gstatic.com/s/oxygen/v5/78wGxsHfFBzG7bRkpfRnCQ.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
}


* {
  font-family :"Oxygen" !important;
}

.order-detail {


  font-weight: bolder;
}

.name {
  text-transform: capitalize;

}

.product, .product-price {
  color: #35aa45;
}

</style>
<div class="container-fluid">
  <div class='panel panel-success'>
    <div class='panel-heading'>
      Thank you for your order <span class='order-detail name'><?php echo $order['name']; ?></span>!

    </div>
    <div class='panel-body'>
      <p class='lead'>You ordered <span class='order-detail product'><?php echo $order['productName'];?></span> valued at
        <span class='order-detail product-price'><?php echo $order['productPrice'];?>$</span>.</p>
      <hr>
      <small>The expected delivery date of the product is <span class='order-detail delivery'><?php echo $order['deliveryDate'];?></span></small>
    </div>
  </div>
</div>
