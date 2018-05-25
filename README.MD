    
    // Pre-create order table
    new OrderEntityRepository();
    // Pre-create order items table
    new OrderItemEntityRepository();
    
    // Create new order
    $order = new OrderEntity();
    $order->setClientId(USER_LOGGED_ID);
    $order->setStatus(ModuleOrders::$order_statuses['new']);
    $order->save();
    
    $module_link = '?p=catalogue&do=articules&product_id={%articule_id%}&articule_id={%articule_id%}';
    
    
    $sum = 0;
    
    // Create products for order
    /** @var CartItemEntity $cart_item */
    foreach ($cart_items as $cart_item) {
        $articule = new ProductArticulEntity($cart_item->getItemId());
    
        $order_item = new OrderItemEntity();
    
        $order_item->setAdditionalProperties(json_encode([
            'cms_link' => $module_link,
            'cms_link_params' => [
                'product_id' => $articule->getProductId(),
                'articule_id' => $articule->getProductId(),
            ],
        ]));
    
        $total_price = ModuleCatalogue::calculatePriceBasedOnAmount($articule, $cart_item->getAmount());
    
        $sum += $total_price;
    
        $order_item->setItemAmount($cart_item->getAmount());
        $order_item->setItemName($articule->getTitle());
        $order_item->setItemPrice(ModuleCatalogue::calculatePricePerOneBasedOnAmount($articule, $cart_item->getAmount()));
        $order_item->setLinkedProductId($cart_item->getItemId());
        $order_item->setOrderId($order->getId());
        $order_item->setTotalPrice($total_price);
        $order_item->setTotalPriceTax(round($total_price * VAT_TAX_RATE, 2));
    
        $order_item->save();
    }
    
    // Update order
    $order->setComment($_POST['comment']);
    $order->setDeliveryDate(strtotime($_POST['delivery_date']));
    $order->setDeliveryId($_POST['selected_delivery_id']);
    $order->setNumber($order->getId());
    $order->setSum($sum);
    $order->save();
    
    // Clear cart
    ModuleCart::clearCurrentCart();
    
    // Show success and redirect to orders
    go(Structure::getPathByLabel('order-history'));