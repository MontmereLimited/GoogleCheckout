GoogleCheckout
--------------

For the time being, this library depends on the [Zend](http://framework.zend.com/) library being included and autoloaded. I've only tested it with 1.11, but it probably works with others too.


Example Usage
-------

    $merchant_id = '123456789123';
    $merchant_key = 'jklFJKLljkJFjkllKJl';

    $order = new GoogleCheckout\Order();
    $order->setMerchantId($merchant_id);
    $order->setMerchantKey($merchant_key);

    $item = new GoogleCheckout\Item();
    $item->setName("testitem");
    $item->setDescription("testdescription");
    $item->setPrice("150.00");
    $item->setQuantity(20);

    $order->addItem($item);

    $redirect_url = $order->getRedirectUrl();

Contributing
------------

If you want to make any changes / add any new features, by all means send a pull request! I only ask that you provide unit tests (I can help with these if you've never used them) and make sure any documentation associated with your contribution is up to date.
