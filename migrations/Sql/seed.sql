 INSERT INTO `product` (`id`, `price`) VALUES (1,100), (2,200) ;
 INSERT INTO `promotion` (`id`, `name`, `type`, `adjustment`, `criteria`)
 VALUES (1,'Black Friday half price sale','date_range_multiplier',0.5,'{\"to\": \"2022-11-28\", \"from\" : \"2022-11-25\"}'),
        (2,'Voucher OU812','fixed_price_voucher',100,'{\"code\": \"OU812\"}');
 INSERT INTO `product_promotion` (`id`, `product_id`, `promotion_id`, `valid_to`) VALUES (1,1,1,'2022-11-28 00:00:00'), (2,1,2,NULL);

