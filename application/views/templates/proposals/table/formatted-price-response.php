<?php
$realPrice = ($price) ? str_replace(array(',', '$'), '', $price) : 0;
$formattedPrice = number_format($realPrice);
$priceBreakdown = '';

if ($services){
    foreach ($services as $service) {
        $priceBreakdown .= "<p class='clearfix'><strong class='title'>" . htmlspecialchars($service->serviceName) . "</strong><strong class='price'>" . htmlspecialchars($service->price) . '</strong></p>';
    }
}
?>
<?php echo $priceBreakdown; ?>